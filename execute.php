<?php

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

header("Content-Type: application/json");

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$senderId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$domanda = isset($message['text']) ? $message['text'] : "";

$domanda = trim($domanda);
$domandaL = trim(strtolower($domanda));
//$risposta = strtolower($domanda);
$risposta = trim('I tecnici sono a lavoro per migliorarmi in modo da farmi rispondere prima e più efficacemente alle tue domande o comandi, dovrai avere pazienza se ancora non capisco tutto quello che mi chiedi. Ti posso fornire la lista dei comandi se mi chiedi "aiuto"');


$listacomandi = '/aiuto - lista dei comandi 
/iscrizione - RISERVATO SOCI, insieme al codice tessera da accesso a dei servizi riservati ai soci
/iscriviavvisi - tutte le informazioni rilevanti sulla tua città e non solo
/contatti - visualizza i contatti dell\'associazione
/scrivi - manda un messaggio all\'associazione, facci sapere suggerimenti e commenti sul bot e sul nostro operato';

$contattiAss = 'Email: info@protezionecivilecasarano.org
Telefono: 08331855789
Fax: 08331850434
Cellulare: 3473912735
PEC: protezionecivilecasarano@pec.it

Puoi contattarci scrivendoci anche da qui. 

Scrivi: /scrivi testodelmessaggio. 

Esempio:
/scrivi ciao, vi segnalo un problema di rilevanza di protezione civile in via Bari. Un saluto da Mario Rossi';


$istr_allerameteo = 'Ecco come puoi usare il comando /allertameteo

/allertameteo ultima - Ti permettere di leggere le informazioni dell\'allerta corrente o appena passata.
/allertameteo iscrizione - Ci permette di avvisarti quando un\'allerta viene diramata.
/allertameteo disiscrizione - Ti permette di non ricevere più avvisi riguardanti eventuali allerte meteo.
/allertameteo info - Ti fa leggere di nuovo questo elenco.';

$lat = 0;
$lon = 0;

date_default_timezone_set('UTC+2');


//---- STAMPA LISTA COMANDI
if($domandaL == 'aiuto' or $domandaL == '/aiuto' or $domandaL == 'aiutami' or $domandaL == 'help' or $domandaL == '/help')
	$risposta = trim($listacomandi);

//---- STAMPA ORARIO
if($domandaL == 'che ore sono?' or $domandaL == 'mi dici l\'orario?' or $domandaL == 'sai dirmi l\'orario?' or $domandaL == 'ore?' or $domandaL == 'mi dici l\'ora?' or $domandaL == 'sai dirmi l\'ora?')
	$risposta = trim(date("H:i:s"));

//---- STAMPA CONTATTI
if($domandaL == 'contatti' or $domandaL == '/contatti')
	$risposta = trim($contattiAss);

//---- KEY CIAO
if($domandaL=='ciao' or $domandaL=='salve' 
or $domandaL=='buongiorno' or $domandaL=='buon giorno'
or $domandaL=='buonasera' or $domandaL=='buona sera'
or $domandaL=='buonpomeriggio' or $domandaL=='buon pomeriggio')
{
	$risposta = "Ciao! Come posso esserti utile?";	
}


$parameters = array('chat_id' => $chatId, "text" => $risposta);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
