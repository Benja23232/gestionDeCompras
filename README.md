# Gestión de Compras 🛒

Sistema colaborativo para registrar productos, asignar consumidores y calcular deudas entre los participantes.  
Permite registrar pagos y mantener actualizado el balance de cada integrante del sistema.

---

## 🚀 Características principales
- **Usuarios (`User`)**: cada participante tiene email, nombre, roles y saldo.  
- **Compras (`Compra`)**: registran fecha, comprador y lista de productos asociados.  
- **Productos (`Producto`)**: incluyen nombre, precio, descuento opcional y consumidores vinculados.  
- **Pagos (`Pago`)**: registran transferencias de dinero entre usuarios (pagador → receptor) con fecha y monto.  
- Cálculo automático de **deudas compartidas** según productos consumidos y pagos realizados.  
- Interfaz pensada para la colaboración y transparencia.

---

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash


git clone https://github.com/Benja23232/gestionDeCompras.git


cd gestionDeCompras

```

2. Instalar dependencias


```bash


composer install
```


3. Configurar entorno
Copiar el archivo .env.example a .env y ajustar la conexión a la base de datos:

```bash


cp .env.example .env

```

env
APP_ENV=dev
APP_SECRET=CHANGE_ME
DATABASE_URL="mysql://root@127.0.0.1:3306/proyec?serverVersion=10.4&charset=utf8mb4"


4. Crear la base de datos
```bash


php bin/console doctrine:database:create


php bin/console doctrine:migrations:migrate

```
o sino


```bash
php bin/console doctrine:schema:update --force
```


🖥️ Uso
Levantar el servidor local de Symfony:

```bash


symfony server:start


Acceder en el navegador:
http://127.0.0.1:8000
```


📌 Tecnologías utilizadas
Symfony 6

Doctrine ORM

Twig

Composer

MySQL/MariaDB

PHP 8.2

JavaScript / CSS

👨‍💻 Autor


Benjamin Desarrollador web y analista de sistemas en formación. Especializado en Symfony, Python, Vue.js y pedagogía técnica.

