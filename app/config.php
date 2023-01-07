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
$DB_SERVER = '127.0.0.1:3306';
$DB_USERNAME = 'root';
$DB_PASSWORD = '';
$DB = 'pleiades';

$CONNECTION_DB = mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB);
# ------------------------------------------------------------------------------
# File Transfer Protocol - FTP config
# ------------------------------------------------------------------------------
$FTP_SERVER = '127.0.0.1';
$FTP_USERNAME = 'admin';
$FTP_PASSWORD = 'admin';
$FILE_MAX_SIZE = 5242880;

$CONNECTION_FTP = ftp_connect($FTP_SERVER);
$AUTHENTICATION_FTP = ftp_login($CONNECTION_FTP, $FTP_USERNAME, $FTP_PASSWORD);
# ------------------------------------------------------------------------------
# Ticket system parameters
# ------------------------------------------------------------------------------
$TICKET_TEAM = ['Tecnologia da informação','Desenvolvimento','DevOps'];
$TICKET_SLA = [8,12,24,48];