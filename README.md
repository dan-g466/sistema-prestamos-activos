# 🚀 Sistema de Gestión de Préstamos y Activos

Aplicación web desarrollada para el control de inventario y gestión de préstamos de activos, con autenticación por roles (Administrador y Aprendiz), enfocada en la automatización de procesos y seguimiento en tiempo real.

---

## 🛠️ Tecnologías utilizadas
- Laravel 12
- PHP
- MySQL
- Tailwind CSS
- Alpine.js

---

## 🔐 Funcionalidades
- Registro e inicio de sesión de usuarios
- Roles: Administrador / Aprendiz
- Gestión de inventario
- Solicitud y aprobación de préstamos
- Sanciones automáticas por mora
- Generación de reportes en PDF
- Importación masiva desde Excel

---

## 📸 Capturas del sistema

### 🔑 Login

<img width="1900" height="907" alt="login" src="https://github.com/user-attachments/assets/b02d8462-34cf-4e74-a1d0-d5db78fe85d4" />



### 📊 Dashboard
<img width="1918" height="1005" alt="image" src="https://github.com/user-attachments/assets/f05d4b95-96c2-4d6a-9c99-8d166a5c185b" />


### 📦 Inventario
<img width="1897" height="917" alt="image" src="https://github.com/user-attachments/assets/b506c2ea-9123-405e-bdaa-d59990eaaf1e" />


### 📋 Préstamos
<img width="1918" height="922" alt="image" src="https://github.com/user-attachments/assets/c8029c45-02ce-48fc-9b56-f308a1c321e0" />


---
## 🎯 Objetivo del proyecto
Desarrollar una solución web que permita gestionar eficientemente el préstamo de activos, reducir errores manuales y mejorar el control administrativo mediante automatización de procesos.

---

## ⚙️ Instalación

```bash
git clone https://github.com/dan-g466/sistema-prestamos-activos.git
cd sistema-prestamos-activos
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
