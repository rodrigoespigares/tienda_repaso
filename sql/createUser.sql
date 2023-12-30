CREATE USER 'repasoUser'@'localhost' IDENTIFIED BY 'cXrpJBft5i';
GRANT ALL PRIVILEGES ON tienda.* TO 'repasoUser'@'localhost';
FLUSH PRIVILEGES;
/* % para todas las conexiones, sino localhost o uno especifico*/
ALTER USER 'repasoUser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'cXrpJBft5i';