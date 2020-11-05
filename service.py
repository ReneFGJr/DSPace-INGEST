#!/usr/bin/env python3
"""
pip install httpserver
pip install gspread oauth2client
pip install tinydb
Very simple HTTP server in python for logging requests
Usage::
    https://www.twilio.com/blog/2017/02/an-easy-way-to-read-and-write-to-a-google-spreadsheet-in-python.html
    ./server.py [<port>]
"""
from http.server import BaseHTTPRequestHandler, HTTPServer
import logging
import tinydb
import html, cgi
import csv
import os
# PORTA DO SERVICO HTTP
port = 3333
project = 'cedap.db'
debug = 1

class S(BaseHTTPRequestHandler):
    def _set_response(self):
        self.send_response(200)
        self.send_header('Content-type', 'text/html')
        self.end_headers()

    def do_GET(self):
        path = self.path
        # Init
        init()
        #logging.info("\nPath: %s\nHeaders:\n%s\n", str(self.path), str(self.headers))
        self._set_response()
        txt = ''
        txt = txt + header() 
        txt = txt + '<div class="content">\n'

        if path == '/':
            txt = txt + iconemenu()

        elif path == '/config/':
            txt = txt + dataset()
            txt = txt + config()
        elif path == '/main/':
            txt = txt + 'Hello'
        elif path == '/dataset/':
            txt = txt + fl()
        else:
            logging.info(path)

        txt = txt + '<div class="col-6">'        
        txt = txt + "GET request for {}".format(self.path)
        txt = txt + '<h1>'+path+'</h1>'
        txt = txt + '</div>'

        txt = txt + '</div>'

        self.wfile.write(txt.encode('utf-8'))        

    def do_POST(self):
        txt = header() 
        path = self.path

        content_length = int(self.headers['Content-Length']) # <--- Gets the size of data
        post_data = self.rfile.read(content_length) # <--- Gets the data itself

        self._set_response()        
        print("=====================================\n")
        print(post_data)
        print("=====================================\n")

        #path
        if path == '/config/':
            txt = txt + dataset()
            txt = txt + config()

            self.wfile.write(txt.encode('utf-8')) 

#CABECALHO DO SERVICO


def mainmenu():
    txt = ''

    return(txt)

def dspace():
    txt = ''
    return(txt)

def dspace_contents():
    return('')

def dspace_dublin_core():
    return('')

def dspace_handle():
    return('')

def dspace_licence():
    return('')

def dataset(file=''):
    txt = ''
    file = 'dataset/escolasnormais.csv'
    with open(file, newline='', encoding='utf-8') as f:
        reader = csv.reader(f, delimiter=',', quoting=csv.QUOTE_NONE)
        print(reader)

        for row in reader:
            if (row[2] == 'A'):
                id = row[0]
                txt = txt + '<br>===>' + id + '===>' + row[2] + " ; "
    return(txt)
    return('')

def init():
    global db
    from tinydb import TinyDB, Query
    if (debug == 1):
        logging.info("Inicializando database")
    db = TinyDB('projects/'+project+'.prj')

def config():
    txt = ''
    txt = txt + '<form action="/config/" method="post">'
    txt = txt + '<div class="container">'
    txt = txt + '<div class="row">'
    txt = txt + '<div class="col-12">'
    txt = txt + '<h1>Configuracoes</h1>'
    txt = txt + '<div class="form-group">'
    txt = txt + '<label for="InputTitle1">Informe o titulo do projeto</label>'
    txt = txt + '<input type="text" class="form-control" name="prjTitle" id="prjTitle" aria-describedby="titleHelp" placeholder="Enter Title">'
    txt = txt + '<small id="emailHelp" class="form-text text-muted">Informe o título do projeto.</small>'
    txt = txt + '</div>'

    txt = txt + '<div class="form-group">'
    txt = txt + '<label for="InputTitle1">Email do resposavel do projeto</label>'
    txt = txt + '<input type="email" class="form-control" name="prjEmail" id="prjEmail" aria-describedby="titleHelp" placeholder="Enter Email">'
    txt = txt + '</div>'    

    txt = txt + '<div class="form-group">'
    txt = txt + '<label for="InputTitle1">Prefixo Handle do projeto</label>'
    txt = txt + '<input type="handle" class="form-control" id="prjHandle" style="width: 100px;">'
    txt = txt + '<small id="emailHelp" class="form-text text-muted" name="prjHandle">Pequena sequencia de letras ou numeros para o prefixo do Handle (ex: sta).</small>'
    txt = txt + '</div>'

    txt = txt + '<button>SALVAR</button>'
    txt = txt + '</form>'

    form = cgi.FieldStorage()
    print(form)
    prjTitle  = html.escape(form["prjTitle"].value)
    prjEmail  = html.escape(form["prjEmail"].value)
    prjHandle  = html.escape(form["prjHandle"].value)
    print(prjTitle+"\n")
    print(prjEmail+"\n")
    print(prjHandle+"\n")
    return(txt)

def fl():
    arr = os.listdir("projects")
    print(arr)
    txt = ''
    with open('dataset/escolasnormais.csv', newline='', encoding='utf-8') as f:
        reader = csv.reader(f, delimiter=',', quoting=csv.QUOTE_NONE)
        for row in reader:
            if (row[2] == 'A'):
                id = row[0]
                txt = txt + '<br>===>' + id + '===>' + row[2] + " ; "
    return(txt)

def iconemenu():
    txt = ''
    txt = txt + '<div class="row">'

    txt = txt + '<div class="col-3">'
    txt = txt + toats("Dataset","Selecionar os dataset para geracao do DIP","Access Dataset","/dataset/")
    txt = txt + '</div>'

    txt = txt + '<div class="col-3">'
    txt = txt + toats("Menu 2","Descriptions 2","GO","/")
    txt = txt + '</div>'
        
    txt = txt + '<div class="col-3">'
    txt = txt + toats("Menu 2","Descriptions 3","O","/")
    txt = txt + '</div>'
 
    txt = txt + '<div class="col-3">'
    txt = txt + toats("Menu 2","Descriptions 4","GO","/")
    txt = txt + '</div>'

    txt = txt + '</div>'
    return(txt)

def toats(title, desc, button,http):
    txt = ''
    txt = txt + '<a href="'+http+'" style="text-decoration: none;">'
    txt = txt + '<div class="card" style="width: 18rem; padding: 50px; border: 0px solid #000000;">'
    txt = txt + '<img src="https://getbootstrap.com/docs/4.5/assets/brand/bootstrap-solid.svg" class="card-img-top" alt="title">'
    txt = txt + '<div class="card-body">'
    txt = txt + '<h5 class="card-title">'+title+'</h5>'
    txt = txt + '<p class="card-text">'+desc+'.</p>'
    #txt = txt + '<a href="#" class="btn btn-primary text-center" style="witdh: 100%">'+button+'</a>'
    txt = txt + '</div>'
    txt = txt + '</div>'
    txt = txt + '</a>'

    return(txt)

def run(server_class=HTTPServer, handler_class=S):
    global port;
    logging.basicConfig(level=logging.INFO)
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    logging.info('Starting httpd...\n')
    try:
        httpd.serve_forever()
    except KeyboardInterrupt:
        pass
    httpd.server_close()
    logging.info('Stopping httpd...\n')

if __name__ == '__main__':
    from sys import argv

    if len(argv) == 2:
        run(port=int(argv[1]))
    else:
        run()