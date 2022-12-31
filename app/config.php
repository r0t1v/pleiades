<?php
# ------------------------------------------------------------------------------
# Pleiades
# ------------------------------------------------------------------------------
date_default_timezone_set('America/Belem');
$SERVER_NAME = 'Pleiades';
$SYSTEM_VERSION = 'v0.1.1';
# ------------------------------------------------------------------------------
# Database config
# ------------------------------------------------------------------------------
$DB_SERVER = "127.0.0.1:3306";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB = "pleiades";

$CONNECTION_DB = mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB);
# ------------------------------------------------------------------------------
# Ticket system parameters
# ------------------------------------------------------------------------------
$TICKET_TEAM = ['Tecnologia da informação','Desenvolvimento','DevOps'];
$TICKET_SLA = [8,12,24,48];