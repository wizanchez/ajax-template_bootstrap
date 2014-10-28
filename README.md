pastelo
=======

POS para el trabajo realizado

Link
Gitimmersion.com

** cambiar el nombre de git
Terminal:
git config --global user.name “NOMBRE_USUARIO”


** cambiar el mail de git
git config –global user.email  NOMBRE@MAIL.USUAIOR

** para clonar o bajar un repositorio
se ubicar en la carpeta  donde se va a bajar y simplemente se escribe
git clone https://github.com/[NOMBRE_APP_A_CLONAR]

https://www.youtube.com/watch?v=udughzlN5M4 min:24:00

congifurar y sincronizar con github

1 establecer una llave ssh: para esto entro a la terminal y coloco 
ssh-keygen [ENTER]
luego me dice a donde guardarla 
Enter file in which to save the key (/Users/wizanchez/.ssh/id_rsa):

Luego pide una clave minimo de 4 caracteres 
Enter passphrase (empty for no passphrase):
Luego repite la clave
Enter same passphrase again
Le damos enter y medice que ha sido salvada
Your identification has been saved in /Users/wizanchez/.ssh/pastelo.
Your public key has been saved in /Users/wizanchez/.ssh/pastelo.pub.
The key fingerprint is:
7d:c8:35:44:76:2c:5a:fe:8c:cb:1f:9b:27:cd:f1:c7 wizanchez@MacBook-Air-de-Wizanchez.local
The key's randomart image is:

+--[ RSA 2048]----+
|           .+..  |
|           oo..  |
|           +o.   |
|         o.o..   |
|        S + .+   |
|           .. o. |
|           . ..+o|
|            o .+E|
|             .+o.|
+-----------------+


MacBook-Air-de-Wizanchez:pastelo wizanchez$

Ahora necesitamos la llave o ver la llave con el comando cat 

MacBook-Air-de-Wizanchez:pastelo wizanchez$ cat /Users/wizanchez/.ssh/pastelo.pub
ssh-rsa A[ACA_GENERA_LA_CLAVE] wizanchez@MacBook-Air-de-Wizanchez.local
MacBook-Air-de-Wizanchez:pastelo wizanchez$ 


Para inicializar la sincronización si coloca
Git init [ENTER]

Para crear archivo :touch README2
Para subir al git : git add README2

** para saber el status  de los archivos se escribe
git status

** para hacer un cometer
git commit –m “este es el primer archivo subido desde pc”

ahora para  conectarme con un repositorio remotamente  coloco

git remote add origin git@github.com:wizanchez/pastelo.git

ahora traigo todo el repositorio

git pull origin master

ss

