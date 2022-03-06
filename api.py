db_user="root"
db_pass=""
db_host="localhost"
db_port=3306
db="stajili"
timeout=5



forget_password_token="LetMeHaveMyPasswordOniiiChan"

salt="ala_b_samar_b_123"

from flask import Flask, render_template, request,send_file,Response
import datetime,os,pymysql,hashlib,json,random



def encode_token(t):
 return hashlib.sha256(t.encode()+salt.encode()).hexdigest()


def get_connection():
 return pymysql.connect(host=db_host,port=db_port,user=db_user,password=db_pass,database=db,autocommit=True,connect_timeout=timeout,cursorclass=pymysql.cursors.DictCursor)

def get_cursor(c):
 return c.cursor()

def close_cursor(c):
 c.close()

def close_connection(c):
 c.close()

def dict_to_json(data):
 response = app.response_class(
        response=json.dumps(data,default=str),
        status=200,
        mimetype='application/json'
    )
 return response


app = Flask(__name__)

def generate_username(co,d,b):
 co.execute("select username from users")
 a=co.fetchall()
 l=[]
 for x in a:
  l.append(x["username"])
 while True:
  u="{}_{}_{}".format(d,b,random.randint(1,100000))
  if u not in l:
   return u



@app.route('/logins/<user_id>', methods = ['POST'])
def get_logins(user_id):
 if all(name in dict(request.form) for name in ['token'])and( len(request.form['token'].strip())>0):
  con=get_connection()
  i=user_id
  c=get_cursor(con)
  c.execute("select username from users where id="+i)
  u=c.fetchall()[0]["username"]
  if (encode_token(u)==request.form['token']):
   c.execute("select email,username,password from users where id="+i)
   try:
    a=c.fetchall()[0]
    close_cursor(c)
    close_connection(con)
    return dict_to_json(a)
   except:
    pass
  close_cursor(c)
  close_connection(con)
 return dict_to_json({"status":"Failed: missing parameters"}),401
 
@app.route('/forget_password', methods = ['POST'])
def forget_password():
 if ((all(name in dict(request.form) for name in ['email','token'])and( len(request.form['email'].strip())>0 and request.form['token'].strip())>0)) and(request.form['token']==forget_password_token):
  con=get_connection()
  i=request.form['email']
  c=get_cursor(con)
  c.execute("select email,username,password from users where email="+i)
  try:
    a=c.fetchall()[0]
    close_cursor(c)
    close_connection(con)
    return dict_to_json(a)
  except:
    pass
  close_cursor(c)
  close_connection(con)
 return dict_to_json({"status":"Failed: missing parameters"}),401


@app.route('/reset_password/<user_id>', methods = ['POST'])
def reset_password(user_id):
 if all(name in dict(request.form) for name in ['token',"old_password",'password'])and( len(request.form['token'].strip())>0 and len(request.form['password'].strip())>0 and len(request.form['old_password'].strip())>0):
  con=get_connection()
  i=user_id
  c=get_cursor(con)
  c.execute("select username,password from users where id="+i)
  d=c.fetchall()[0]
  print(d,encode_token(d["username"]))
  u=d["username"]
  op=d["password"]
  if ((encode_token(u)==request.form['token'])and (op==request.form['old_password'])):
   p=request.form['password']
   c.execute("update users set password='"+p+"' where id="+i)
   close_cursor(c)
   close_connection(con)
   return dict_to_json({"status":"Success"})
  close_cursor(c)
  close_connection(con)
 return dict_to_json({"status":"Failed: missing parameters"}),401


@app.route('/update/<user_id>', methods = ['POST'])
def update(user_id):
 if all(name in dict(request.form) for name in ['email','first_name','last_name','state','keywords','token'])and( len(request.form['email'].strip())>0 and len(request.form['token'].strip())>0 and len(request.form['first_name'].strip())>0 and len(request.form['last_name'].strip())>0 and len(request.form['state'].strip())>0 and len(request.form['keywords'].strip())>0):
  con=get_connection()
  i=user_id
  c=get_cursor(con)
  c.execute("select username from users where id="+i)
  u=c.fetchall()[0]["username"]
  if (encode_token(u)==request.form['token']):
   f=request.form['first_name'].lower()
   l=request.form['last_name'].lower()
   s=request.form['state'].lower()
   e=request.form['email']
   k=",".join([ y for y in request.form['keywords'].lower().split(',') if y ])
   i=user_id
   print("update users set first_name='"+f+"',last_name='"+l+"',email='"+e+"',state='"+s+"',keywords='"+k+"' where id="+i)
   c.execute("update users set first_name='"+f+"',last_name='"+l+"',email='"+e+"',state='"+s+"',keywords='"+k+"' where id="+i)
   close_cursor(c)
   close_connection(con)
   return dict_to_json({"status":"Success"})
  close_cursor(c)
  close_connection(con)
 return dict_to_json({"status":"Failed: missing parameters"}),401
 

@app.route('/create', methods = ['POST'])
def create():
 if all(name in dict(request.form) for name in ['email','f_name','l_name','state','keywords','password1','password2'])and(len(request.form['email'].strip())>0 and len(request.form['password1'].strip())>0 and len(request.form['password2'].strip())>0  and len(request.form['f_name'].strip())>0 and len(request.form['l_name'].strip())>0 and len(request.form['state'].strip())>0 and len(request.form['keywords'].strip())>0):
  if request.form['password1'].strip()!=request.form['password2'].strip():
   return dict_to_json({"status":"Failed: unmatched passwords"}),401
  con=get_connection()
  c=get_cursor(con)
  e=request.form['email']
  u=generate_username(c,request.form['f_name'],request.form['l_name'])
  f=request.form['f_name'].lower()
  l=request.form['l_name'].lower()
  s=request.form['state'].lower()
  k=",".join([ y for y in request.form['keywords'].lower().split(',') if y ])
  p=request.form['password1']
  a=c.execute("select username where email='"+e+"'")
  c.execute("insert into users (username,email,first_name,last_name,password,state,keywords) values('"+u+"','"+e+"','"+f+"','"+l+"','"+p+"','"+s+"','"+k+"')")
  close_cursor(c)
  close_connection(con)
  return dict_to_json({"status":"Success"})
 return dict_to_json({"status":"Failed: missing parameters"}),401
   
@app.route('/states')
def get_states():
 con=get_connection()
 c=get_cursor(con)
 c.execute('select DISTINCT  address from offres ORDER BY address ASC')
 a=c.fetchall()
 close_cursor(c)
 close_connection(con)
 return dict_to_json(a)


@app.route('/search', methods = ['POST'])
def offres():
 a={}
 status_c=401
 if ('keywords' in dict(request.form) and 'state' in dict(request.form)) and(len(request.form['state'].strip())>0 and len(request.form['keywords'].strip())>0):
  con=get_connection()
  s=con.escape("%"+request.form['state'].lower().replace('é','e').replace('è','e').replace('à','a')+"%")
  k=[ y for y in request.form['keywords'].lower().split(',') if y ]
  k="lower(description) like "+" or lower(description) like ".join(([ con.escape("%"+x.lower()+"%")  for x in k]))+" "
  c=get_cursor(con)
  print("select * from offres where lower(address) like "+s+" and ( "+k+" )")
  c.execute("select * from offres where lower(address) like "+s+" and ( "+k+" )")
  a=c.fetchall()
  close_cursor(c)
  close_connection(con)
  status_c=200
 return dict_to_json(a),status_c


@app.route('/login', methods = ['POST'])
def login():
 a={}
 status_c=401
 if ('user' in dict(request.form) and 'pass' in dict(request.form)) and(len(request.form['user'].strip())>0 and len(request.form['pass'].strip())>0):
  con=get_connection()
  user=request.form['user']
  pwd=request.form['pass']
  c=get_cursor(con)
  c.execute("select * from users where username='"+user+"' and password='"+pwd+"'")
  try:
   a=c.fetchall()[0]
   print(a)
   a.update({"token":encode_token(a['username'])})
   status_c=200
  except Exception as ex:
   print(ex)
  close_cursor(c)
  close_connection(con)
 return dict_to_json(a),status_c
 


if __name__ == '__main__':
   app.run(debug = True,host="0.0.0.0")
