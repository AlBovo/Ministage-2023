#!/usr/bin/env python3
from flask import Flask, render_template, request, redirect, make_response
from functools import wraps
import jwt, uuid, os, logging

app = Flask(__name__)

USERS = {} # {userID: {'saldo': saldo, 'prodotti': [prodotti acquistati]}}
SECRET_KEY = os.urandom(36).hex()
assert len(SECRET_KEY) == 36 * 2

'''
The `OBJECTS` dictionary contains information about the products available for purchase in the PaguriShop web application. Each product is represented by a dictionary with the following keys:

- `id`: a unique identifier for the product
- `name`: the name of the product
- `foto`: the filename of the product's image
- `description`: a short description of the product
- `text`: additional information about the product
- `price`: the price of the product in PaguriShop's currency (not specified in the code)

The `OBJECTS` dictionary is used throughout the application to display information about the available products and to handle purchases made by users.
'''
OBJECTS = {
    '1' : {
        'id' : '1',
        'name' : 'La flag',
        'foto' : 'flag.png',
        'description' : 'Prova a prendermi se ci riesci',
        'text' : 'flag{Wh3r3_d1d_y0u_g3t_th3_m0n3ys?}',
        'price' : 1000
    },
    '2' : {
        'id' : '2',
        'name' : 'Il gabibbo',
        'foto' : 'gabibbo.png',
        'description' : 'Mascotte epica quasi regalata',
        'text' : 'Bella scelta (meglio della flag) ma adesso ti sta tracciando e tra poco saprà dove abiti',
        'price' : 10
    },
    '3' : {
        'id' : '3',
        'name' : 'I segreti di stato di St3pNy',
        'foto' : 'stepny.png',
        'description' : 'Il vero motivo per cui ha evaso le tasse',
        'text' : 'Non è un vero segreto di stato, semplicemente gli faceva comodo così poteva shoppare su Fortnite',
        'price' : 500
    }
}

def authorized(f):
    """
    A decorator function that checks if the user is authorized to access a certain route.
    If the user is not authorized, it creates a new account and sets a cookie with a unique session ID.
    If the user is authorized, it returns the decorated function with the user ID as an argument.

    Args:
        f (function): The function to be decorated.

    Returns:
        function: The decorated function.
    """
    @wraps(f)
    def decorated(*args, **kwargs):
        try:
            token = request.cookies['session']
        except:
            token = None
        if not token:
            token = str(uuid.uuid4())
            jwtEnc = jwt.encode({'userID': token}, SECRET_KEY, algorithm='HS256')
            response = make_response(redirect('/'))
            response.set_cookie('session', jwtEnc)
            USERS[token] = {'saldo': 500, 'prodotti': []}
            my_logger.info(f'[{token}] ha creato un nuovo account')
            return response
        try:
            data = jwt.decode(token, SECRET_KEY, algorithms=['HS256'])
        except:
            token = str(uuid.uuid4())
            jwtEnc = jwt.encode({'userID': token}, SECRET_KEY, algorithm='HS256')
            response = make_response(redirect('/'))
            response.set_cookie('session', jwtEnc)
            USERS[token] = {'saldo': 500, 'prodotti': []}
            my_logger.info(f'[{token}] ha creato un nuovo account')
            return response
        return f(data["userID"], *args, **kwargs)
    return decorated

@app.route('/', methods=['GET'])
@authorized
def index(userID: str):
    """
    Renders the index page with a list of objects and the user's saldo.

    Args:
        userID (str): The ID of the user.

    Returns:
        str: The rendered HTML template.
    """
    objects = [x for x in OBJECTS.values()]
    saldo = USERS[userID]['saldo']
    if request.args.get('error') != None:
        return render_template('index.html', error=request.args.get('error'), objects=objects, saldo=str(saldo))
    return render_template('index.html', objects=objects, saldo=str(saldo))

@app.route('/history', methods=['GET'])
@authorized
def history(userID: str):
    """
    Renders the history.html template with the list of products purchased by the user and their current balance.

    Args:
        userID (str): The ID of the user whose purchase history is being displayed.

    Returns:
        The rendered history.html template with the list of purchased products and the user's current balance.
    """
    return render_template('history.html', objects=[OBJECTS[x] for x in USERS[userID]['prodotti']], saldo=str(USERS[userID]['saldo']))

@app.route('/buy', methods=['POST'])
@authorized
def buy(userID: str):
    """
    This function handles the purchase of products by a user.

    Args:
        userID (str): The ID of the user making the purchase.

    Returns:
        A redirect to the user's purchase history page.

    Raises:
        None
    """
    id = request.form['id']
    if id not in ['1', '2', '3']:
        return make_response(redirect('/?error=Prodotto non valido'))
    
    qty = request.form['qty']
    try:
        qty = int(qty)
    except:
        return make_response(redirect('/?error=Il carrello contiene una quantità non valida'))

    if USERS[userID]['saldo'] < OBJECTS[id]['price'] * int(qty):
        return make_response(redirect('/?error=Non hai abbastanza soldi'))

    if(qty > 0):
        USERS[userID]['prodotti'].append(id)
    #TODO: controllare che qty sia un numero positivo maggiore di 0
    USERS[userID]['saldo'] -= OBJECTS[id]['price'] * int(qty) # aggiorno il saldo
    
    if id == '1':
        my_logger.info(f'[{userID}] ha aggiunto la flag al carrello') # vediamo se funziona
    
    return redirect('/history')

# Guardo solo i miei log (altrimenti mi esplode la console)
logging.getLogger("werkzeug").setLevel(logging.ERROR)
my_logger = logging.getLogger(__name__)
my_logger.setLevel(logging.INFO)
my_handler = logging.StreamHandler()
my_logger.addHandler(my_handler)
    
if __name__ == '__main__':
    app.run('0.0.0.0', port=80, debug=True)