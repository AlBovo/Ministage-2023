FROM python:3.8-alpine

COPY requirements.txt .
RUN pip install -r requirements.txt
COPY . .
WORKDIR /src
EXPOSE 80

CMD ["python", "main.py"]