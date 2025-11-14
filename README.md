# WordPress - Guía de Instalación y Configuración

Este documento proporciona instrucciones detalladas para configurar este proyecto WordPress en un nuevo computador.

## 📋 Tabla de Contenidos

- [Requisitos Previos](#requisitos-previos)
- [Paso 1: Clonar el Repositorio](#paso-1-clonar-el-repositorio)
- [Paso 2: Configurar la Base de Datos](#paso-2-configurar-la-base-de-datos)
- [Paso 3: Configurar WordPress (wp-config.php)](#paso-3-configurar-wordpress-wp-configphp)
- [Paso 4: Configurar el Servidor Web](#paso-4-configurar-el-servidor-web)
- [Paso 5: Configurar Permisos de Archivos](#paso-5-configurar-permisos-de-archivos)
- [Paso 6: Completar la Instalación de WordPress](#paso-6-completar-la-instalación-de-wordpress)
- [Solución de Problemas](#solución-de-problemas)

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente en tu computador:

### Software Necesario

- **Servidor Web**: Apache 2.4+ o Nginx 1.18+
- **PHP**: Versión 7.4 o superior (se recomienda PHP 8.0+)
- **MySQL** o **MariaDB**: Versión 5.7+ (MySQL) o 10.3+ (MariaDB)
- **Git**: Para clonar el repositorio

### Extensiones de PHP Requeridas

- `php-mysqli` o `php-mysql`
- `php-xml`
- `php-mbstring`
- `php-curl`
- `php-zip`
- `php-gd`
- `php-json`

### Instalación en Ubuntu/Debian

```bash
# Actualizar el sistema
sudo apt update && sudo apt upgrade -y

# Instalar Apache, MySQL y PHP
sudo apt install apache2 mysql-server php php-mysql php-xml php-mbstring php-curl php-zip php-gd libapache2-mod-php git -y

# Iniciar servicios
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql
```

---

## Paso 1: Clonar el Repositorio

Clona este repositorio en el directorio web de tu servidor:

```bash
# Navega al directorio web de Apache
cd /var/www/html

# Clona el repositorio
sudo git clone https://github.com/David34-bw/WordPress.git mi-sitio-wordpress

# Cambia al directorio del proyecto
cd mi-sitio-wordpress
```

**Nota**: Reemplaza `mi-sitio-wordpress` con el nombre que desees para tu sitio.

---

## Paso 2: Configurar la Base de Datos

### 2.1 Acceder a MySQL

```bash
sudo mysql -u root -p
```

### 2.2 Crear la Base de Datos y Usuario

Ejecuta los siguientes comandos SQL:

```sql
-- Crear la base de datos
CREATE DATABASE wordpress_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear un usuario para WordPress
CREATE USER 'wordpress_user'@'localhost' IDENTIFIED BY 'tu_contraseña_segura';

-- Otorgar privilegios al usuario
GRANT ALL PRIVILEGES ON wordpress_db.* TO 'wordpress_user'@'localhost';

-- Aplicar los cambios
FLUSH PRIVILEGES;

-- Salir de MySQL
EXIT;
```

**Importante**: Reemplaza `tu_contraseña_segura` con una contraseña fuerte.

---

## Paso 3: Configurar WordPress (wp-config.php)

### 3.1 Copiar el Archivo de Configuración

```bash
# Asegúrate de estar en el directorio del proyecto
cd /var/www/html/mi-sitio-wordpress

# Copiar el archivo de ejemplo
sudo cp wp-config-sample.php wp-config.php
```

### 3.2 Editar wp-config.php

Abre el archivo con tu editor preferido:

```bash
sudo nano wp-config.php
```

Modifica las siguientes líneas con la información de tu base de datos:

```php
// ** Configuración de la base de datos ** //
define( 'DB_NAME', 'wordpress_db' );
define( 'DB_USER', 'wordpress_user' );
define( 'DB_PASSWORD', 'tu_contraseña_segura' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

### 3.3 Generar Claves de Seguridad

Visita https://api.wordpress.org/secret-key/1.1/salt/ para generar claves únicas.

Reemplaza estas líneas en `wp-config.php`:

```php
define( 'AUTH_KEY',         'pega-aquí-la-clave-generada' );
define( 'SECURE_AUTH_KEY',  'pega-aquí-la-clave-generada' );
define( 'LOGGED_IN_KEY',    'pega-aquí-la-clave-generada' );
define( 'NONCE_KEY',        'pega-aquí-la-clave-generada' );
define( 'AUTH_SALT',        'pega-aquí-la-clave-generada' );
define( 'SECURE_AUTH_SALT', 'pega-aquí-la-clave-generada' );
define( 'LOGGED_IN_SALT',   'pega-aquí-la-clave-generada' );
define( 'NONCE_SALT',       'pega-aquí-la-clave-generada' );
```

Guarda y cierra el archivo (Ctrl+O, Enter, Ctrl+X en nano).

---

## Paso 4: Configurar el Servidor Web

### Opción A: Apache

#### 4.1 Crear un Virtual Host

Crea un nuevo archivo de configuración:

```bash
sudo nano /etc/apache2/sites-available/mi-sitio-wordpress.conf
```

Pega la siguiente configuración:

```apache
<VirtualHost *:80>
    ServerAdmin admin@example.com
    ServerName mi-sitio.local
    ServerAlias www.mi-sitio.local
    DocumentRoot /var/www/html/mi-sitio-wordpress
    
    <Directory /var/www/html/mi-sitio-wordpress/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/wordpress_error.log
    CustomLog ${APACHE_LOG_DIR}/wordpress_access.log combined
</VirtualHost>
```

**Nota**: Reemplaza `mi-sitio.local` con tu dominio o nombre de host deseado.

#### 4.2 Activar el Sitio y Desactivar el Default

```bash
# Habilitar el módulo de reescritura de Apache
sudo a2enmod rewrite

# Activar el nuevo sitio
sudo a2ensite mi-sitio-wordpress.conf

# Desactivar el sitio default de Apache
sudo a2dissite 000-default.conf

# Reiniciar Apache para aplicar los cambios
sudo systemctl restart apache2
```

#### 4.3 Configurar /etc/hosts (Opcional - para desarrollo local)

Si estás usando un dominio local como `mi-sitio.local`:

```bash
sudo nano /etc/hosts
```

Agrega esta línea:

```
127.0.0.1   mi-sitio.local www.mi-sitio.local
```

### Opción B: Nginx

#### 4.1 Crear un Server Block

```bash
sudo nano /etc/nginx/sites-available/mi-sitio-wordpress
```

Pega la siguiente configuración:

```nginx
server {
    listen 80;
    server_name mi-sitio.local www.mi-sitio.local;
    root /var/www/html/mi-sitio-wordpress;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    location = /favicon.ico {
        log_not_found off;
        access_log off;
    }

    location = /robots.txt {
        allow all;
        log_not_found off;
        access_log off;
    }

    location ~* \.(css|gif|ico|jpeg|jpg|js|png)$ {
        expires max;
        log_not_found off;
    }
}
```

**Nota**: Ajusta la versión de PHP-FPM según tu instalación (php7.4-fpm, php8.0-fpm, etc.)

#### 4.2 Activar el Sitio y Desactivar el Default

```bash
# Crear enlace simbólico para activar el sitio
sudo ln -s /etc/nginx/sites-available/mi-sitio-wordpress /etc/nginx/sites-enabled/

# Desactivar el sitio default
sudo rm /etc/nginx/sites-enabled/default

# Verificar la configuración de Nginx
sudo nginx -t

# Reiniciar Nginx
sudo systemctl restart nginx

# Iniciar PHP-FPM si no está corriendo
sudo systemctl start php8.1-fpm
sudo systemctl enable php8.1-fpm
```

---

## Paso 5: Configurar Permisos de Archivos

Es importante configurar los permisos correctos para que WordPress funcione adecuadamente:

```bash
# Navega al directorio del proyecto
cd /var/www/html/mi-sitio-wordpress

# Establecer el propietario correcto (www-data es el usuario de Apache/Nginx)
sudo chown -R www-data:www-data /var/www/html/mi-sitio-wordpress

# Establecer permisos para directorios
sudo find /var/www/html/mi-sitio-wordpress -type d -exec chmod 755 {} \;

# Establecer permisos para archivos
sudo find /var/www/html/mi-sitio-wordpress -type f -exec chmod 644 {} \;

# Permisos especiales para wp-config.php (más restrictivo por seguridad)
sudo chmod 640 wp-config.php
```

---

## Paso 6: Completar la Instalación de WordPress

### 6.1 Acceder al Instalador Web

Abre tu navegador web y visita:

```
http://mi-sitio.local
```

O si estás usando localhost:

```
http://localhost/mi-sitio-wordpress
```

### 6.2 Completar el Asistente de Instalación

WordPress te guiará a través de un asistente de instalación:

1. **Selecciona el idioma** preferido
2. **Ingresa la información del sitio**:
   - Título del sitio
   - Nombre de usuario administrador
   - Contraseña segura
   - Correo electrónico
3. Haz clic en **"Instalar WordPress"**
4. Inicia sesión con las credenciales creadas

### 6.3 Verificar la Instalación

Una vez completada la instalación:

- Accede al panel de administración: `http://mi-sitio.local/wp-admin`
- Verifica que puedas ver y editar el sitio
- Revisa que los plugins y temas estén disponibles

---

## Solución de Problemas

### Problema: Error de conexión a la base de datos

**Solución**:
- Verifica que MySQL esté corriendo: `sudo systemctl status mysql`
- Confirma que las credenciales en `wp-config.php` sean correctas
- Asegúrate de que el usuario de la base de datos tenga los privilegios necesarios

### Problema: Error 403 Forbidden

**Solución**:
- Verifica los permisos de archivos (Paso 5)
- Asegúrate de que `AllowOverride All` esté configurado en Apache
- Revisa los logs: `sudo tail -f /var/log/apache2/wordpress_error.log`

### Problema: Página en blanco o Error 500

**Solución**:
- Aumenta el límite de memoria de PHP en `wp-config.php`:
  ```php
  define('WP_MEMORY_LIMIT', '256M');
  ```
- Habilita el modo de depuración en `wp-config.php`:
  ```php
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);
  ```
- Revisa el log de errores de PHP y Apache

### Problema: Los permalinks no funcionan

**Solución**:
- Asegúrate de que `mod_rewrite` esté habilitado en Apache:
  ```bash
  sudo a2enmod rewrite
  sudo systemctl restart apache2
  ```
- Verifica que `.htaccess` tenga los permisos correctos

### Problema: No se pueden subir archivos

**Solución**:
- Crea el directorio de uploads si no existe:
  ```bash
  sudo mkdir -p /var/www/html/mi-sitio-wordpress/wp-content/uploads
  sudo chown -R www-data:www-data /var/www/html/mi-sitio-wordpress/wp-content/uploads
  sudo chmod -R 755 /var/www/html/mi-sitio-wordpress/wp-content/uploads
  ```
- Verifica los límites de subida en PHP (`upload_max_filesize` y `post_max_size`)

---

## 🔒 Notas de Seguridad

- **Nunca** versiones el archivo `wp-config.php` en Git (ya está en .gitignore)
- Mantén WordPress, plugins y temas actualizados
- Usa contraseñas fuertes para la base de datos y el administrador
- Considera instalar un plugin de seguridad como Wordfence
- Habilita HTTPS en producción (usa Let's Encrypt)

---

## 📚 Recursos Adicionales

- [Documentación oficial de WordPress](https://wordpress.org/support/)
- [Codex de WordPress](https://codex.wordpress.org/)
- [Guía de instalación de WordPress](https://wordpress.org/support/article/how-to-install-wordpress/)

---

## 📝 Información del Proyecto

- **Repositorio**: https://github.com/David34-bw/WordPress
- **WordPress Version**: Latest stable version
- **Licencia**: GPL v2 o posterior

---

## 🤝 Contribuciones

Si encuentras algún problema o tienes sugerencias para mejorar esta guía, por favor abre un issue en el repositorio.

---

**¡Disfruta de tu sitio WordPress!** 🎉
