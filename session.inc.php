<?php
/**
 * session.inc.php startet die Session und lenkt auf das https-Protokoll um. Alternativ kann das bereits vom Apacheserver übernommen werden, dann ist dieser Schritt nicht notwendig
 */
session_start();

// TODO: First, do the HTTP/HTTPS check and redirect as shown in the lecture notes.
/**
 * XAMPP benutzt kein offizielles Zertifikat. Man kann es im Browser zu den Vertrauenswürdigen Zertifikaten hinzufügen, oder die Warnhinweise ignorieren
 * Aber Produktiv gehen sollte man mit diesem Zertifikat nicht.
 * Eine Umlenkung auf https kann auch über die Apache-Konfiguration erfolgen oder .htaccess, falls man keinen Zugriff auf die Apachekonfiguration bekommt beim ISP
 * @link http://www.sysadminslife.com/linux/quicktipp-weiterleitung-redirect-von-http-auf-https-via-apache-oder-htaccess/
 * Wir zeigen eine Möglichkeit, wie es von PHP aus gestaltetet werden kann. Produktiv würden wir aber empfehlen die oben genannten Varianten mit einem
 * Zertifikat von @link https://letsencrypt.org/ (gratis) oder eines bei einem anderen Anbieter zu kaufen.
 */

if (!isset($_SERVER["HTTPS"]) || strcmp($_SERVER["HTTPS"], "off") === 0) {
    // 301-Weiterleitung um SEO zu erhalten
    // @link http://www.seomotion.org/de/suchmaschinenoptimierung/301-weiterleitung/
    header("HTTP/1.1 301 Moved Permanently"); // Optional
    // Umlenkung auf https
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"]);
    exit();
}
