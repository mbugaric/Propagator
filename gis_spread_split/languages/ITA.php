<?php 
/**
* AdriaFirePropagator
* @ Copyright (C) 2015 Katedra za modeliranje i inteligentne računalne sustave, Sveučilište u Splitu, Fakultet elektrotehnike, strojarstva i brodogradnje (FESB)
* @ All rights reserved
* @ Verzija 1.0 $Revision: 1.00 $
* @ Zadnja promjena 19.02.2016.
**/

/**
* @	Tekst se može grupirati na slijedeći način:
* @ SECTION_START (naziv_na_eng | naziv_na_hrv |...)
* @ ...
* @ SECTION_END
**/
/* 
U UTF-8 sva naša slova se prikazuju normalno, Kodovi za ISO-8859-2 za naša slova
 š - š - &#353;
 Š - Š - &#352;
 ž - ž - &#158;
 Ž - Ž - &#142; 
 ć - ć - &#230;
 Ć - Ć - &#198; 
 č - č - &#269; 
 Č - Č - &#268;
 đ - đ - &#273;
 Đ - Đ - &#272;
 Mogu se uključivati i varijable
 Npr. DEFINE('_VALID_AZ09',"Molimo Vas da unesete valjano %s.  Više od  %d znakova koji sadrže 0-9,a-z,A-Z.  Bez razmaka i posebnih znakova.");
 Ali onda ispis mora ići u printf naredbi
 printf( _VALID_AZ09, _PROMPT_UNAME, 4 );
 Mogu se uključivati i html tagovi
 Npr. DEFINE('_TEMPLATE_WARN','<font color=\"red\"><b>Predložak nije pronađen! Traženi predložak:</b></font>');
*/

/* SECTION_START( Character set - header | Skup znakova - zaglavlje ) */
DEFINE('_NATPIS_CHARSET',"UTF-8");
/* SECTION_END */

/* SECTION_START( Acknowledgement | Potvrda ) */
DEFINE('_NATPIS_FOOTER',"HOLISTIC AdriaFirePropagator v.1.0/2015");
DEFINE('_NATPIS_EU',"Il progetto era parzialmente finanziato dall\'Unione Europea.<br />Il contenuto di questo website non rispecchia il parere ufficiale dell\'Unione Europea.");
DEFINE('_NATPIS_TITLE',"AdriaFirePropagator");
DEFINE('_NATPIS_COPYRIGHT',"Copyright (c) 2015");
DEFINE('_NATPIS_DESCRIPTION',"AdriaFirePropagator.");
DEFINE('_NATPIS_KEYWORDS',"incendi forestali, monitoraggio iniziale,  simulazione dell\'incendio forestale");
DEFINE('_NATPIS_PRICEKAJTE',"Si prega di aspettare!");
DEFINE('_NATPIS_UPOZORENJE',"il progetto HOLISTIC è co-finanziato dall\'Unione Europea, Strumento per la preadesione e assistenza. <br />Il contenuto di questo website non rispecchia il parere ufficiale dell\'Unione Europea.<br /><br />Il sistema può essere utilizzato solo dagli utenti autorizzati. I tentativi di accesso non autorizzato sono reati penali.<br /> Digitando login e password l\'utente viene indirizzato al preciso livello di cui ha l\'autorizzazione.");
DEFINE('_NATPIS_DISCLAIMER',"<b style=\color:red\>DISCLAIMER:</b><br />AdriaFirePropagator è stato sviluppato dalla Facoltà di ingegneria elettronica, ingegneria meccanica e Architettura navale <br />Università di Spalato come un partner del progetto IPA Holistic.<br />AdriaFirePropagator è un sistema sperimentale. Gli sviluppatori non si assumono alcuna responsabilità per il suo utilizzo da parte di altri soggetti,<br /> e non offrono alcuna garanzia , espressa o implicita , sulla sua qualità , precisione, affidabilità o qualsiasi altra caratteristica.<br /> Apprezzeremmo riscontri se si utilizza il software. <br /><b style=\color:red\>Entrando in questo sito l\'utente riconosce e accetta questa dichiarazione legale. Se non si accetta questa, non utilizzare il sito.</b><br /><br />Risoluzione raccomandata: HD 1080 (1920 x 1080 px) - Risoluzione minima: HD 720 (1280 x 720 px)");
DEFINE('_NATPIS_DISCLAIMER_RISK',"<b style=\color:red\>DISCLAIMER:</b><br />AdriaFireRisk is being developed at the Faculty of Electrical Engineering, Mechanical Engineering and Naval Architecture <br />University of Split as a part of the IPA Holistic Project.<br />AdriaFireRisk is an experimental system. The developers assume no responsibility whatsoever for its use by other parties,<br /> and makes no guarantees, expressed or implied, about its quality, accuracy, reliability or any other characteristic.<br /> We would appreciate acknowledgement if the software is used. <br /><b style=\color:red\>By entering this site you acknowledge and agree to this legal disclaimer. If you do not agree to this, do not use the site.</b><br /><br />Recommended resolution: HD 1080 (1920 x 1080 px) - Minimum resolution: HD 720 (1280 x 720 px)");
DEFINE('_NATPIS_REGISTRIRANI_KORISNICI',"Utenti registrati");
DEFINE('_NATPIS_IDENTIFIKACIJA',"Username");
DEFINE('_NATPIS_ZAPORKA',"Password");
DEFINE('_NATPIS_POTVRDA',"Invio");
DEFINE('_NATPIS_POTVRDA_TITLE',"Click per iniziare AdriaFirePropagator");
DEFINE('_NATPIS_WRONG_LOGIN',"Login non corretta");
DEFINE('_NATPIS_NO_LOGIN',"Devi essere riconosciuto, così prima vai a <a href=\http://propagator.adriaholistic.eu\>LOGIN PAGE</a>");
/* SECTION_END */

/* SECTION_START( Main | Osnovno ) */
DEFINE('_GIS_OK',"OK");
DEFINE('_GIS_CANCEL',"Cancella");
DEFINE('_GIS_USER',"User");
DEFINE('_GIS_USER_ADMIN',"Utenti Amministratore");
DEFINE('_GIS_ARESURE',"Sei sicuro?");
DEFINE('_GIS_CORINE_LEGENDA',"CORINE");
DEFINE('_GIS_CORINE_LEGENDA_DESCRIPTION',"Descrizione dettagliata delle classi del CORINE");
DEFINE('_GIS_RUNNING',"Caricando ...");
DEFINE('_GIS_RUNNING_FIRST',"Ben tornato,");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI',"Trasparenza");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI_DESCRIPTION',"Sistema trasparenza per tutti i layers");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI_SLOJEVA',"Layer di controllo della trasparenza");
DEFINE('_GIS_UKLJUCI',"Abilita");
DEFINE('_GIS_ISKLJUCI',"Disabilita");
DEFINE('_GIS_NIJE_OMOGUCENO',"Non disponibile");
DEFINE('_GIS_OSNOVNI_SLOJEVI',"Layers base");
DEFINE('_GIS_OSTALI_SLOJEVI',"Altri layers");
DEFINE('_GIS_GOOGLE_PHYSICAL',"Database di Google ");
DEFINE('_GIS_GOOGLE_STREETS_',"Strade di Google");
DEFINE('_GIS_GOOGLE_HYBRID',"Ortofoto di Google");
DEFINE('_GIS_GOOGLE_SATELLITE',"Google satellite");
DEFINE('_GIS_VJETAR_TRENUTNI',"Vento - attuale");
DEFINE('_GIS_VJETAR_VLASTITI',"Vento - personalizzato");
DEFINE('_GIS_VEGETACIJA',"Vegetazione: CORINE");
DEFINE('_GIS_MODEL_ALBINI',"Vegetazione: Albini-Anderson - personalizzato");
DEFINE('_GIS_MODEL_SCOTT',"Vegetazione: Scott-Burgan - personalizzato");
DEFINE('_GIS_MODEL_ALBINI_DEFAULT',"Vegetazione: Albini-Anderson - predefinito");
DEFINE('_GIS_MODEL_SCOTT_DEFAULT',"Vegetazione: Scott-Burgan - predefinito");
DEFINE('_GIS_POZAR_RASTER',"Risultato della simulazione dell\'incendio (raster)");
DEFINE('_GIS_POZAR_VECTOR',"Risultato della simulazione dell\'incendio (vettoriale)");
DEFINE('_GIS_LAT_LON_KOORDINATE',"Coordinate (lon-lat)");
DEFINE('_GIS_KOORDINATE_TOCKE',"Coordinate di un punto:");
DEFINE('_GIS_KOORDINATE_SJEVER',"N");
DEFINE('_GIS_KOORDINATE_ISTOK',"E");
DEFINE('_GIS_SIMULACIJA',"Simulazione");
DEFINE('_GIS_TRENUTNA_SIMULACIJA',"Inizio simulazione (attuale)");
DEFINE('_GIS_VLASTITA_SIMULACIJA',"Inizio simulazione (personalizzata)");
DEFINE('_GIS_POSTAVKE_S',"Impostazioni");
DEFINE('_GIS_POSTAVKE_SIMULACIJE',"Proprietà della simulazione");
DEFINE('_GIS_VLASTITI_PARAM_VJETAR',"Parametri personalizzati (vento)");
DEFINE('_GIS_VLASTITI_PARAM_VLAGA',"Parametri personalizzati (umidità del combustibile)");
DEFINE('_GIS_CALCROS_VLATITI',"Calcola ROS (personalizzato)");
DEFINE('_GIS_POZARNAFRONTA_START',"Fonte del fuoco (inizio)");
DEFINE('_GIS_POZARNAFRONTA_STOP',"Fonte del fuoco (stop)");
DEFINE('_GIS_VRIJEME',"Tempo");
DEFINE('_GIS_KORAK',"Intervallo temporale");
DEFINE('_GIS_QUA_SPEED',"Qualità/Velocità");
DEFINE('_GIS_PARAMETRI_GORIVA',"Parametri dell\'incendio");
DEFINE('_GIS_FUEL_MAP_MANAGE',"Calcola mappe del combustibile");
DEFINE('_TIME_MIN',"Tempo (min)");
DEFINE('_TIMESTEP_MIN',"Intervallo temporale (min)");
DEFINE('_SIMULATION_SPEED',"Velocità");
DEFINE('_SIMULATION_QUALITY',"Qualità");
DEFINE('_SIMULATION_ANIMATION_QUE',"animazione della simulazione?");
DEFINE('_WIND_PROPERTIES',"PROPRIETÀ DEL VENTO");
DEFINE('_WIND_FORECAST_HOUR',"Previsione (ora):");
DEFINE('_WIND_HOUR',"Ora:");
DEFINE('_PARAMETERS_ASC',"ASCII");
DEFINE('_PARAMETERS_BY_DATE',"con la data");
DEFINE('_GET_WIND_ONLINE',"Ottieni i parametri del vento on-line");
DEFINE('_GET_METEO',"Meteo");
DEFINE('_GET_FILE_COLON',"File:");
DEFINE('_DIRECTION_COLON',"Direzione:");
DEFINE('_SPEED_COLON',"Velocità:");
DEFINE('_DIRECTION',"Direzione:");
DEFINE('_WIND_DATE',"Data:");
DEFINE('_SPEED',"Velocità:");
DEFINE('_VALUE',"Valore");
DEFINE('_UPDATE_WIND_SETTINGS',"Aggiorna le impostazioni del vento");
DEFINE('_UPDATE_STILL_WORKING',"Si prega di aspettare! Sto elaborando");
DEFINE('_MOIS_PROPERTIES',"PROPRIETÀ\' DELL\'UMIDITÀ\' DEL COMBUSTIBILE");
DEFINE('_GET_MOIS_ONLINE',"Ottieni i parametri del combustibile on-line");
DEFINE('_GET_MOIS_LIVE',"umid_viva");
DEFINE('_GET_MOIS_1H',"umid1h");
DEFINE('_GET_MOIS_10H',"umid10h");
DEFINE('_GET_MOIS_100H',"umid100h");
DEFINE('_GIS_MOIS_LIVE',"Umidità combustibile (vivo)");
DEFINE('_GIS_MOIS_LIVE_CUSTOM',"Umidità combustibile (vivo) - personalizzato");
DEFINE('_PARAMETERS_ONLINE',"On-line");
DEFINE('_UPDATE_MOIS_SETTINGS',"Aggiorna impostazioni umidità del combustibile");
DEFINE('_GIS_UNSUCCESSFUL_ATTEMPT',"Tentativo fallito");
DEFINE('_GIS_DATA_INCOMPLETE',"Dati incompleti");
DEFINE('_GIS_DATA_MISSING',"Dati mancanti");
DEFINE('_GIS_SUCCESS',"Riuscito");
DEFINE('_GIS_WIND_SUCCESS',"aggiornamento del vento riuscito");
DEFINE('_GIS_MOIS_SUCCESS',"Aggiornamento dell\'umidità del combustibile riuscito");
DEFINE('_GIS_PLS_RUN_ROS',"Si prega di ricalcolare ROS");
DEFINE('_GIS_MIRIP',"AdriaFireRisk");
DEFINE('_GIS_CHOSEN_FUEL_MODEL',"Scegli modello del combustibile:");
DEFINE('_GIS_ALBINI_CUSTOM',"Albini-Anderson (personalizzato)");
DEFINE('_GIS_SCOTT_CUSTOM',"Scott-Burgan (personalizzato)");
DEFINE('_GIS_ALBINI_DEFAULT',"Albini-Anderson (predefinito)");
DEFINE('_GIS_SCOTT_DEFAULT',"Scott-Burgan (predefinito)");
DEFINE('_GIS_CHOSEN_FUEL_MODEL_SHORT',"Modello del combustibile:");
DEFINE('_GIS_FUEL_DIALOG',"Le mappe del combustibile non sono state trovate! Si consiglia di iniziare il calcolo ora. Si prega di notare che la simulazione potrebbe non essere disponibile prima che questo processo sia finito. Vuoi avviare il processo di calcolo ora?");
DEFINE('_GIS_FUEL_DIALOG_MANUAL',"Sei sicuro che desideri ricalcolare le mappe del combustibile personalizzate! Si prega di notare che la simulazione potrebbe non essere disponibile prima che questo processo sia finito. Vuoi avviare il processo di calcolo ora?");
DEFINE('_GIS_FUEL_DIALOG_DEFAULT',"Le mappe del combustibile PREDEFINITE non sono state trovate! Si prega di contattare l\'amministratore");
DEFINE('_GIS_FUEL_FAILURE',"Il calcolo delle mappe del combustibile non funziona come previsto. La ragione potrebbe essere il file di grandi dimensioni. Si prega, ricaricare AdriaFirePropagator e verificare se il calcolo è ancora in esecuzione. In caso contrario, si prega di contattare l\'amministratore!");
DEFINE('_GIS_FUEL_STILL_RUNNING',"L\'elaborazione delle mappe del combustibile è ancora in esecuzione! Le simulazioni potrebbero non essere disponibili!");
DEFINE('_GIS_NORESULTS_SIMULATION',"L\'ultima simulazione ha restituito come risultato NULLO (potrebbe non essere un incendio)!");
DEFINE('_GIS_NOT_SUPPORTED',"non ancora supportato!");
DEFINE('_GIS_ERUPTIVERISK',"Rischio di incendio eruttivo");
DEFINE('_GIS_ADDFIREBARRIER',"Aggiungi le barriere antincendio");
DEFINE('_GIS_ADDFIREBARRIER_DESCRIPTION',"Le barriere antincendio rappresentano aree non interessate dal fuoco. Inizia disegnando l\'area da qualche parte sulla mappa cliccando il pulsante sinistro del mouse e termina con un doppio clic del mouse.");
DEFINE('_GIS_CLEARIREBARRIER',"Togli le barriere antincendio");
DEFINE('_GIS_CLEARIREBARRIER_DESCRIPTION',"Rimuovi TUTTE le barriere antincendio disegnate sulla mappa!");
DEFINE('_GIS_STOPPREVIOUSCALCS',"Termina");
DEFINE('_GIS_STOPPREVIOUSCALCS_DESCRIPTION',"Forza la chiusura di tutte le elaborazioni iniziate dall\'utente. Utilizzate solo se necessario!");
DEFINE('_GIS_REFRESHALLLAYERS',"Ricarica");
DEFINE('_GIS_REFRESHALLLAYERS_DESCRIPTION',"Forza il ricaricamento di tutti i layers visibili");
DEFINE('_GIS_PREVIOUSMETEOCALCSERROR',"Dati meteo non ancora disponibili! Si prega di a aspettare!");
DEFINE('_GIS_PREVIOUSCALCSERROR',"L\'elaborazione precedente sta ancora girando! Si prega di aspettare!");
DEFINE('_GIS_PREVIOUSSIMSERROR',"L\'elaborazione precedente sta ancora girando! Si prega di aspettare!");
DEFINE('_GIS_STOPPREVIOUSCALCS_QUES',"Sei sicuro che desideri terminare le precedenti elaborazioni? La pagina Web non sarà attiva per alcuni momenti.");
DEFINE('_GIS_FIREBARRIER',"Barriera(e) antincendio");
DEFINE('_GIS_FIREPERIMETER',"Fronte del fuoco");
DEFINE('_GIS_SETDEFAULTVIEW',"Imposta come predefinito");
DEFINE('_GIS_SETDEFAULTVIEW_DESCRIPTION',"La vista corrente è stata salvata come predefinita! La prossima volta che l\'applicazione sarà aperta la vista sarà come ora!");
DEFINE('_GIS_LOGOUT',"Esci");
DEFINE('_GIS_LANGUAGE_CHANGE',"Lingua");
DEFINE('_GIS_LANGUAGE_EDIT',"Modifica lingua");
DEFINE('_GIS_ADDPERIMETER',"Aggiungi fronte del fuoco");
DEFINE('_GIS_ADDPERIMETER_DESCRIPTION',"I fronti del fuoco rappresentano aree già interessate dal fuoco e possono essere trattate come punti di accensione. Inizia disegnando l\'area da qualche parte sulla mappa con un clic del pulsante sinistro del mouse e termina con un doppio clic del mouse.");
DEFINE('_GIS_CLEARPERIMETER',"Togli il fronte del fuoco");
DEFINE('_GIS_CLEARPERIMETER_DESCRIPTION',"Rimuovi tutti i fronti del fuoco disegnati sulla mappa!");
DEFINE('_GIS_IGNITION_TYPE',"Tipi di accensione:");
DEFINE('_GIS_POINT_IGNITION',"Punto");
DEFINE('_GIS_PERIMETER_IGNITION',"Fronte del fuoco");
DEFINE('_GIS_PERIMETER_IGNITION_SHORT',"Fronte");
DEFINE('_GIS_MODEL_SHORT_SCOTT_DFLT',"Scott (predefinito)");
DEFINE('_GIS_MODEL_SHORT_ALBINI_DFLT',"Albini (predefinito)");
DEFINE('_GIS_MODEL_SHORT_SCOTT_CSTM',"Scott (personalizzato)");
DEFINE('_GIS_MODEL_SHORT_ALBINI_CSTM',"Albini (personalizzato)");
DEFINE('_GIS_BARRIERS_CANNOT_BE_USED_CURRENT',"Le barriere del fuoco saranno ignorate usando la simulazione attuale!");
DEFINE('_GIS_OSMMAP',"Open street map");
DEFINE('_GIS_PRECIP',"Pioggia");
DEFINE('_GIS_FWI',"FWI");
DEFINE('_GIS_MOISTURE_GENERAL',"Umidità del combustibile");
DEFINE('_GIS_WIND_GENERAL',"Vento");
DEFINE('_GIS_SLOPE',"Pendenza");
DEFINE('_GIS_ROSBASE',"La percentuale di propagazione verticale");
DEFINE('_GIS_ROSMAX',"La massima percentuale di propagazione");
DEFINE('_GIS_ROSMAXDIR',"La massima direzione del ROS");
DEFINE('_GIS_DEGREES_SHORT',"gradi");
DEFINE('_GIS_PARAMETRI_WIND_REDUCTION',"Parametri di riduzione del vento");
DEFINE('_GIS_WIND_REDUCTION_VALUE',"coefficiente di riduzione del vento");
DEFINE('_GIS_CUSTOM',"personalizzato");
DEFINE('_GIS_HEMMLAN',"Coefficiente di Hellman");
/* SECTION_END */

/* SECTION_START( Fuel Models | Modeli goriva ) */
DEFINE('_FUEL_MODEL_PARAMETERS',"Parametri del modello del combustibile");
DEFINE('_FILTER',"Filtra:");
DEFINE('_SORT',"Ordina");
DEFINE('_SAVE',"Salva");
DEFINE('_RESET',"Resetta");
DEFINE('_IMPORT',"Importa");
DEFINE('_EXPORT',"Esporta");
DEFINE('_ASCENDING',"ASCII");
DEFINE('_DESCENDING',"Descrizione");
DEFINE('_SAVE_ALL',"Salva (tutto)");
DEFINE('_FUEL_ALBINI',"Albini-Anderson");
DEFINE('_FUEL_SCOTT',"Scott-Burgan");
DEFINE('_FUEL_MODEL_TYPE',"Tipo di modello del combustibile");
DEFINE('_FUEL_1H_FUEL_LOAD',"1-h carico del combustibile");
DEFINE('_FUEL_10H_FUEL_LOAD',"10-h carico del combustibile");
DEFINE('_FUEL_100H_FUEL_LOAD',"100-h carico del combustibile");
DEFINE('_FUEL_LIVE_HERB_FUEL_LOAD',"Carico vivo del combustibile erbaceo");
DEFINE('_FUEL_LIVE_WOODY_FUEL_LOAD',"Carico vivo del combustibile legnoso");
DEFINE('_FUEL_1H_SURFACE_AREAVOLUME_RATIO',"1-h Area superficiale/percentuale in volume");
DEFINE('_FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO',"Area superficiale dello strato erbaceo vivo/percentuale in volume");
DEFINE('_FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO',"Area superficiale dello strato legnoso vivo/percentuale in volume");
DEFINE('_FUEL_BED_DEPTH',"Combustibile della lettiera morta");
DEFINE('_FUEL_DEAD_MOIS_EXTINCT',"Umidità di estinzione del combustibile morto");
DEFINE('_FUEL_DEAD_HEAT_CONT',"Contenuto termico del combustibile morto");
DEFINE('_FUEL_LIVE_HEAT_CONT',"Contenuto termico del combustibile vivo");
DEFINE('_UNIT_TONS',"tonellate");
DEFINE('_UNIT_AC',"acri");
DEFINE('_UNIT_FT',"piedi");
DEFINE('_UNIT_PERCENT',"percentuale");
DEFINE('_UNIT_BTULIB',"Btu/libbra");
DEFINE('_FUEL_ANDERSON_01',"Erba bassa");
DEFINE('_FUEL_ANDERSON_02',"Sottobosco erbaceo");
DEFINE('_FUEL_ANDERSON_03',"Erba alta");
DEFINE('_FUEL_ANDERSON_04',"Macchia alta");
DEFINE('_FUEL_ANDERSON_05',"Cespugliato");
DEFINE('_FUEL_ANDERSON_06',"Cespugli a riposo, residui di utilizzazioni");
DEFINE('_FUEL_ANDERSON_07',"Sottobosco");
DEFINE('_FUEL_ANDERSON_08',"lettiera compatta aghi di pino");
DEFINE('_FUEL_ANDERSON_09',"Aghi di pino o lettiera di latifoglie");
DEFINE('_FUEL_ANDERSON_10',"lettiera e sottobosco");
DEFINE('_FUEL_ANDERSON_11',"Carico leggero utilizzazioni forestali ");
DEFINE('_FUEL_ANDERSON_12',"Carico medio utilizzazioni forestali");
DEFINE('_FUEL_ANDERSON_13',"Carico pesante utilizzazioni forestali");
DEFINE('_FUEL_SCOTT_00-1',"NB1-Urbano intensivo ed estensivo");
DEFINE('_FUEL_SCOTT_00-2',"NB2-Neve/ghiaccio");
DEFINE('_FUEL_SCOTT_00-3',"NB3-Colture agrarie, mantenute in condizioni non incendiabili");
DEFINE('_FUEL_SCOTT_00-4',"NB8-Acqua");
DEFINE('_FUEL_SCOTT_00-5',"NB9-Terreni nudi");
DEFINE('_FUEL_SCOTT_01',"GR1-Erba bassa di clima secco, bassissimo carico");
DEFINE('_FUEL_SCOTT_02',"GR2-Erba di clima secco, basso carico");
DEFINE('_FUEL_SCOTT_03',"GR3-Erba scadente di clima umido, basso carico");
DEFINE('_FUEL_SCOTT_04',"GR4-Erba di clima secco, carico moderato");
DEFINE('_FUEL_SCOTT_05',"GR5-Erba di clima umido, basso carico");
DEFINE('_FUEL_SCOTT_06',"GR6-Erba di clima umido, carico moderato");
DEFINE('_FUEL_SCOTT_07',"GR7-Erba di clima secco, carico elevato");
DEFINE('_FUEL_SCOTT_08',"GR8-Erba molto scadente di clima umido, carico elevato");
DEFINE('_FUEL_SCOTT_09',"GR9-Erba di clima umido, carico estremamente elevato");
DEFINE('_FUEL_SCOTT_10',"GS1-Erba-arbusti di clima secco, carico basso");
DEFINE('_FUEL_SCOTT_11',"GS2-Erba-arbusti di clima secco, carico moderato");
DEFINE('_FUEL_SCOTT_12',"GS3-Erba-arbusti di clima umido, carico moderato");
DEFINE('_FUEL_SCOTT_13',"GS4-Erba-arbusti di clima umido, carico elevato");
DEFINE('_FUEL_SCOTT_14',"SH1-Arbusti di clima secco, carico basso");
DEFINE('_FUEL_SCOTT_15',"SH2-Arbusti di clima secco, carico moderato");
DEFINE('_FUEL_SCOTT_16',"SH3-Arbusti di clima umido, carico moderato");
DEFINE('_FUEL_SCOTT_17',"SH4-Foresta-Arbusti di clima umido, carico basso");
DEFINE('_FUEL_SCOTT_18',"SH5-Arbusti di clima secco, carico alto");
DEFINE('_FUEL_SCOTT_19',"SH6-Arbusti di clima umido, carico basso");
DEFINE('_FUEL_SCOTT_20',"SH7-Arbusti di clima secco, carico molto alto");
DEFINE('_FUEL_SCOTT_21',"SH8-Arbusti di clima umido, carico alto");
DEFINE('_FUEL_SCOTT_22',"SH9-Arbusti di clima umido, carico molto alto");
DEFINE('_FUEL_SCOTT_23',"TU1-Foresta-Arbusti-Erba di clima secco, carico basso");
DEFINE('_FUEL_SCOTT_24',"TU2-Foresta-Arbusti di clima umido, carico moderato");
DEFINE('_FUEL_SCOTT_25',"TU3-Foresta-Arbusti-Erba di clima umido, carico moderato");
DEFINE('_FUEL_SCOTT_26',"TU4-Strette conifere con lettiera");
DEFINE('_FUEL_SCOTT_27',"TU5-Foresta-Arbusti di clima secco, elevato carico");
DEFINE('_FUEL_SCOTT_28',"TL1-Lettiera compatta di conifere, basso carico");
DEFINE('_FUEL_SCOTT_29',"TL2-Lettiera di latifoglie, basso carico");
DEFINE('_FUEL_SCOTT_30',"TL3-Lettiera di conifere, carico moderato");
DEFINE('_FUEL_SCOTT_31',"TL4-Tronchi di piccolo diametro al suolo");
DEFINE('_FUEL_SCOTT_32',"TL5-Lettiera di conifere, carico alto");
DEFINE('_FUEL_SCOTT_33',"TL6-Lettiera di latifoglie, moderato carico");
DEFINE('_FUEL_SCOTT_34',"TL7-Tronchi di grosso diametro al suolo");
DEFINE('_FUEL_SCOTT_35',"TL8-Lettiera di aghi lunghi di pino");
DEFINE('_FUEL_SCOTT_36',"TL9-Lettiera di latifoglie, moderato carico");
DEFINE('_FUEL_SCOTT_37',"SB1-Combustibile da abbatimenti, carico basso");
DEFINE('_FUEL_SCOTT_38',"SB2-Combustibile da leggeri diradamenti e moderati abbattimenti");
DEFINE('_FUEL_SCOTT_39',"SB3-Combustibile da moderati diradamenti e molti abbattimenti");
DEFINE('_FUEL_SCOTT_40',"SB4-Combustibile da importanti abbattimenti");
DEFINE('_FUEL_BACK_TO_TOP',"Ritorna all\'inizio");
DEFINE('_FUEL_STATUS_ALBINI_RESET',"Resetta il database di Albini-Anderson");
DEFINE('_WIND_STATUS_RESET_COMPLETE',"Resetta completamente il database della riduzione dell\'intensità del vento");
DEFINE('_FUEL_STATUS_SCOTT_RESET',"Resetta il database di Scott-Burgan");
DEFINE('_FUEL_STATUS_RESET',"Vuoi ripristinare il modello del combustibile con i  valori predefiniti! Tutte le modifiche precedenti andranno perse!");
DEFINE('_WIND_STATUS_RESET',"Vuoi ripristinare i parametri della riduzione del vento con i  valori predefiniti! Tutte le modifiche precedenti andranno perse!");
DEFINE('_FUEL_STATUS_RESET_CANCELLED',"Ripristino cancellato!");
DEFINE('_FUEL_STATUS_SAVE',"Si desidera salvare tutte le modifiche a entrambi i modelli di combustibile?");
DEFINE('_WIND_STATUS_SAVE',"Desideri salvare tutte le modifiche?");
DEFINE('_FUEL_STATUS_SAVE_CANCELLED',"Salvataggio cancellato!");
DEFINE('_FUEL_STATUS_NOT_SAVED',"Modifiche non salvate!");
DEFINE('_FUEL_STATUS_SAVED',"Modifiche salvate!");
DEFINE('_FUEL_ENTER_FILENAME',"Si prega di digitare il nome del file");
DEFINE('_FUEL_STATUS_EXPORT_DONE',"Eseguita l\'esportazione del file di incendi!");
DEFINE('_FUEL_STATUS_EXPORT_CANCELLED',"L\'esportazione del file di incendi è stata cancellata!");
DEFINE('_FUEL_STATUS_NO_FILE_CHOSEN',"il file non è stato selezionato!");
DEFINE('_FUEL_STATUS_ERROR_NUMBER_CAT',"File di incendi non importato (Il numero di categorie non è corretto)");
DEFINE('_COMPLETED_WITH_ERRORS',"Completato con ERRORI");
DEFINE('_CONTINUE_IN_BCK',"La comunicazione con il server meteo continuerà in background. I dati verranno visualizzati quando saranno ottenuti! Questo potrebbe richiedere alcuni minuti!");
DEFINE('_FUEL_STATUS_FUEL_IMPORTED',"Il file di incendi è stato importato!");
DEFINE('_PRJ_ERROR',"Il Prj file sistemato e adeguato a EPSG:900913");
DEFINE('_METEO_ERROR',"Problema a ottenere i files meteo. Si prega di contattare l\'amministratore!");
/* SECTION_END */
?>
