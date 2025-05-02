**pasos para ejecutar el proyecto
1. debe tener instalado un servidor php
2. debe tener instalado postgres sql
3. en la ruta api/config se encuentra el archivo de la bd para ejecutarlo en pgAdmin4

**ENDPOINT
Endpoints
● POST /api/login → Iniciar sesión. -> /Juegodellaberinto/user-api/login
● POST /api/new-maze → Generar un laberinto.  -> /Juegodellaberinto/user-api/new-maze
● POST /api/move → Mover jugador ({ direction: "derecha" }).  -> /Juegodellaberinto/user-api/move
● GET /api/status → Obtener estado actual.  -> /Juegodellaberinto/user-api/status/3
● POST /api/reset → Reiniciar partida  -> /Juegodellaberinto/user-api/reset
● POST /api/register → Registrar jugador ({ name, email }).  -> /Juegodellaberinto/user-api/register
● GET /api/ranking → Obtener ranking de jugadores  -> 
