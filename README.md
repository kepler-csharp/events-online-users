# 🎟️ TicketNow
 
Sistema web desarrollado en **Laravel** para la compra y gestión de tickets de eventos mediante una arquitectura basada en consumo de APIs externas, utilizando autenticación **JWT** y sesiones persistentes.
 
---
 
## 📋 Descripción
 
TicketNow es una aplicación web orientada a usuarios que desean:
 
- Visualizar eventos disponibles
- Comprar tickets
- Gestionar reservas
- Autenticarse mediante un gateway de autenticación
- Mantener sesiones persistentes mediante JWT
El proyecto funciona como cliente frontend en Laravel consumiendo endpoints externos documentados con **Swagger** mediante `Http Client`.
 
---
 
## 🛠️ Tecnologías utilizadas
 
| Tecnología | Uso |
|---|---|
| Laravel | Framework principal |
| MySQL | Base de datos |
| Docker | Contenedores y entorno |
| Swagger | Documentación de APIs |
| JSON Web Token | Autenticación |
| Bootstrap | Estilos y UI |
| Laravel HTTP Client | Consumo de APIs externas |
 
---
 
## 🏗️ Arquitectura
 
El proyecto utiliza una arquitectura desacoplada donde:
 
- Laravel funciona como aplicación independiente frontend/backend híbrida
- Los datos y autenticación son consumidos desde APIs externas
- La autenticación se realiza mediante JWT
- El token es almacenado en sesiones de Laravel
- Las rutas protegidas utilizan middleware personalizado basado en sesiones
```
Laravel Application
        │
        ▼
HTTP Client
        │
        ▼
Swagger/API Gateway
        │
        ▼
Authentication Service + Event Services
        │
        ▼
MySQL
```
 
---
 
## ✅ Funcionalidades
 
- [x] Login de usuarios
- [x] Registro de usuarios
- [x] Landing page con eventos disponibles
- [x] Gestión de reservas
- [x] Dashboard de usuario
- [x] Middleware personalizado para protección de rutas
- [x] Persistencia de sesión mediante JWT
- [x] Consumo de APIs externas
- [x] Validación de autenticación mediante token
- [x] Logout de sesión
---
 
## 🔐 Sistema de autenticación
 
La autenticación funciona mediante:
 
1. Laravel consume la API de autenticación externa
2. La API retorna un **JWT**
3. Laravel almacena en sesiones:
   - `token`
   - Datos del usuario
4. Middleware personalizado protege rutas privadas
5. Las solicitudes autenticadas utilizan **Bearer Token** mediante `Http Client`
**Ejemplo:**
 
```php
$response = Http::withToken(session('auth_token'))
    ->get($endpoint);
```
 
---
 
## ⚙️ Variables de entorno necesarias
 
Configurar el archivo `.env`:
 
```env
AUTH_SERVICE_URL=http://localhost:5201
```
 
---
 
## 🚀 Instalación del proyecto
 
### 1. Clonar repositorio
 
```bash
git clone <repository-url>
```
 
### 2. Entrar al proyecto
 
```bash
cd TicketNow
```
 
### 3. Instalar dependencias
 
```bash
composer install
npm install
```
 
### 4. Configurar variables de entorno
 
```bash
cp .env.example .env
```
 
### 5. Generar key de Laravel
 
```bash
php artisan key:generate
```
 
### 6. Levantar contenedores Docker
 
```bash
docker compose up -d
```
 
### 7. Ejecutar migraciones (si aplica)
 
```bash
php artisan migrate
```
 
### 8. Iniciar proyecto
 
```bash
php artisan serve
```
 
---
 
## 🛡️ Middleware personalizado
 
El proyecto utiliza middleware personalizado para validar sesiones autenticadas:
 
```php
if (!session()->has('auth_token')) {
    return redirect('/');
}
```
 
---
 
## 📁 Estructura del proyecto
 
```
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Services/
├── Models/
├── resources/
│   └── views/
├── routes/
└── config/
```
 
---
 
## 🧩 Servicios
 
La lógica de negocio se encuentra desacoplada mediante **Services**:
 
- `AuthService`
- `EventService`
- `ReservationService`
Esto permite:
 
- Controladores limpios
- Reutilización de código
- Mantenimiento sencillo
- Mejor escalabilidad
---
 
## 🐳 Docker
 
El proyecto utiliza Docker para:
 
- Entorno consistente
- Ejecución de servicios
- Despliegue simplificado
```bash
docker compose up -d
```
 
---
 
## 🔄 Flujo de autenticación
 
```
Usuario Login
      │
      ▼
Laravel HTTP Client
      │
      ▼
Swagger Auth API
      │
      ▼
JWT Token
      │
      ▼
Laravel Session
      │
      ▼
Protected Routes
```
 
---
 
## 🔮 Mejoras futuras
 
- [ ] Integración de pagos
- [ ] Panel administrativo
- [ ] Roles y permisos
- [ ] Historial de compras
- [ ] Notificaciones
- [ ] QR para tickets
- [ ] Sistema de favoritos
---
 
## 👤 Autor
 
Proyecto desarrollado como plataforma de gestión de eventos y tickets utilizando **Laravel** y arquitectura basada en APIs.
 
---
 
## 📄 Licencia
 
Proyecto de uso académico y educativo.
