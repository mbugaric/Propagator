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
DEFINE('_NATPIS_EU',"Ovaj projekt je djelomično financiran od Europske unije.<br />Sadržaj ovog Web prikaza ne odražava službeno mišljenje Eutropske unije.");
DEFINE('_NATPIS_TITLE',"AdriaFirePropagator");
DEFINE('_NATPIS_COPYRIGHT',"Copyright (c) 2015");
DEFINE('_NATPIS_DESCRIPTION',"AdriaFirePropagator.");
DEFINE('_NATPIS_KEYWORDS',"požari raslinja, simulacija ponašanja požara, simulacija širenja požara");
DEFINE('_NATPIS_PRICEKAJTE',"Molim vas pričekajte!");
DEFINE('_NATPIS_UPOZORENJE',"");
DEFINE('_NATPIS_DISCLAIMER',"");
DEFINE('_NATPIS_REGISTRIRANI_KORISNICI',"Registrirani korisnici");
DEFINE('_NATPIS_IDENTIFIKACIJA',"");
DEFINE('_NATPIS_ZAPORKA',"");
DEFINE('_NATPIS_POTVRDA',"");
DEFINE('_NATPIS_POTVRDA_TITLE',"");
DEFINE('_NATPIS_WRONG_LOGIN',"");
DEFINE('_NATPIS_NO_LOGIN',"Trebate biti prijavljeni, zato najprije otiđite na <a href=\"http://propagator.adriaholistic.eu\">STRANICU PRIJAVE</a>");
/* SECTION_END */

/* SECTION_START( Main | Osnovno ) */
DEFINE('_GIS_OK',"");
DEFINE('_GIS_CANCEL',"");
DEFINE('_GIS_USER',"Korisnik");
DEFINE('_GIS_USER_ADMIN',"Administriranje korisnika");
DEFINE('_GIS_ARESURE',"");
DEFINE('_GIS_CORINE_LEGENDA',"CORINE legenda");
DEFINE('_GIS_CORINE_LEGENDA_DESCRIPTION',"");
DEFINE('_GIS_RUNNING',"");
DEFINE('_GIS_RUNNING_FIRST',"");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI',"Prozirnost slojeva");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI_DESCRIPTION',"");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI_SLOJEVA',"");
DEFINE('_GIS_UKLJUCI',"");
DEFINE('_GIS_ISKLJUCI',"");
DEFINE('_GIS_NIJE_OMOGUCENO',"");
DEFINE('_GIS_OSNOVNI_SLOJEVI',"");
DEFINE('_GIS_OSTALI_SLOJEVI',"");
DEFINE('_GIS_GOOGLE_PHYSICAL',"");
DEFINE('_GIS_GOOGLE_STREETS_',"");
DEFINE('_GIS_GOOGLE_HYBRID',"");
DEFINE('_GIS_GOOGLE_SATELLITE',"");
DEFINE('_GIS_VJETAR_TRENUTNI',"");
DEFINE('_GIS_VJETAR_VLASTITI',"");
DEFINE('_GIS_VEGETACIJA',"");
DEFINE('_GIS_MODEL_ALBINI',"");
DEFINE('_GIS_MODEL_SCOTT',"");
DEFINE('_GIS_MODEL_ALBINI_DEFAULT',"");
DEFINE('_GIS_MODEL_SCOTT_DEFAULT',"");
DEFINE('_GIS_POZAR_RASTER',"");
DEFINE('_GIS_POZAR_VECTOR',"");
DEFINE('_GIS_LAT_LON_KOORDINATE',"");
DEFINE('_GIS_KOORDINATE_TOCKE',"");
DEFINE('_GIS_KOORDINATE_SJEVER',"");
DEFINE('_GIS_KOORDINATE_ISTOK',"");
DEFINE('_GIS_SIMULACIJA',"");
DEFINE('_GIS_TRENUTNA_SIMULACIJA',"");
DEFINE('_GIS_VLASTITA_SIMULACIJA',"");
DEFINE('_GIS_POSTAVKE_S',"");
DEFINE('_GIS_POSTAVKE_SIMULACIJE',"");
DEFINE('_GIS_VLASTITI_PARAM_VJETAR',"");
DEFINE('_GIS_VLASTITI_PARAM_VLAGA',"");
DEFINE('_GIS_CALCROS_VLATITI',"");
DEFINE('_GIS_POZARNAFRONTA_START',"");
DEFINE('_GIS_POZARNAFRONTA_STOP',"");
DEFINE('_GIS_VRIJEME',"");
DEFINE('_GIS_KORAK',"");
DEFINE('_GIS_QUA_SPEED',"");
DEFINE('_GIS_PARAMETRI_GORIVA',"");
DEFINE('_GIS_FUEL_MAP_MANAGE',"");
DEFINE('_TIME_MIN',"");
DEFINE('_TIMESTEP_MIN',"");
DEFINE('_SIMULATION_SPEED',"");
DEFINE('_SIMULATION_QUALITY',"");
DEFINE('_SIMULATION_ANIMATION_QUE',"");
DEFINE('_WIND_PROPERTIES',"");
DEFINE('_WIND_FORECAST_HOUR',"");
DEFINE('_WIND_HOUR',"");
DEFINE('_PARAMETERS_ASC',"");
DEFINE('_PARAMETERS_BY_DATE',"");
DEFINE('_GET_WIND_ONLINE',"");
DEFINE('_GET_METEO',"");
DEFINE('_GET_FILE_COLON',"");
DEFINE('_DIRECTION_COLON',"");
DEFINE('_SPEED_COLON',"");
DEFINE('_DIRECTION',"");
DEFINE('_WIND_DATE',"");
DEFINE('_SPEED',"");
DEFINE('_VALUE',"");
DEFINE('_UPDATE_WIND_SETTINGS',"");
DEFINE('_UPDATE_STILL_WORKING',"");
DEFINE('_MOIS_PROPERTIES',"");
DEFINE('_GET_MOIS_ONLINE',"");
DEFINE('_GET_MOIS_LIVE',"");
DEFINE('_GET_MOIS_1H',"");
DEFINE('_GET_MOIS_10H',"");
DEFINE('_GET_MOIS_100H',"");
DEFINE('_GIS_MOIS_LIVE',"");
DEFINE('_GIS_MOIS_LIVE_CUSTOM',"");
DEFINE('_PARAMETERS_ONLINE',"");
DEFINE('_UPDATE_MOIS_SETTINGS',"");
DEFINE('_GIS_UNSUCCESSFUL_ATTEMPT',"");
DEFINE('_GIS_DATA_INCOMPLETE',"");
DEFINE('_GIS_DATA_MISSING',"");
DEFINE('_GIS_SUCCESS',"");
DEFINE('_GIS_WIND_SUCCESS',"");
DEFINE('_GIS_MOIS_SUCCESS',"");
DEFINE('_GIS_PLS_RUN_ROS',"");
DEFINE('_GIS_MIRIP',"");
DEFINE('_GIS_CHOSEN_FUEL_MODEL',"");
DEFINE('_GIS_ALBINI_CUSTOM',"");
DEFINE('_GIS_SCOTT_CUSTOM',"");
DEFINE('_GIS_ALBINI_DEFAULT',"");
DEFINE('_GIS_SCOTT_DEFAULT',"");
DEFINE('_GIS_CHOSEN_FUEL_MODEL_SHORT',"");
DEFINE('_GIS_FUEL_DIALOG',"");
DEFINE('_GIS_FUEL_DIALOG_MANUAL',"");
DEFINE('_GIS_FUEL_DIALOG_DEFAULT',"");
DEFINE('_GIS_FUEL_FAILURE',"");
DEFINE('_GIS_FUEL_STILL_RUNNING',"");
DEFINE('_GIS_NORESULTS_SIMULATION',"");
DEFINE('_GIS_NOT_SUPPORTED',"");
DEFINE('_GIS_ERUPTIVERISK',"");
DEFINE('_GIS_ADDFIREBARRIER',"Dodaj požarne barijere");
DEFINE('_GIS_ADDFIREBARRIER_DESCRIPTION',"");
DEFINE('_GIS_CLEARIREBARRIER',"Izbriši požarne barijere");
DEFINE('_GIS_CLEARIREBARRIER_DESCRIPTION',"");
DEFINE('_GIS_STOPPREVIOUSCALCS',"Zaustavljanje simulacije");
DEFINE('_GIS_STOPPREVIOUSCALCS_DESCRIPTION',"");
DEFINE('_GIS_REFRESHALLLAYERS',"Osvježi sve slojeve");
DEFINE('_GIS_REFRESHALLLAYERS_DESCRIPTION',"");
DEFINE('_GIS_PREVIOUSMETEOCALCSERROR',"");
DEFINE('_GIS_PREVIOUSCALCSERROR',"");
DEFINE('_GIS_PREVIOUSSIMSERROR',"");
DEFINE('_GIS_STOPPREVIOUSCALCS_QUES',"");
DEFINE('_GIS_FIREBARRIER',"");
DEFINE('_GIS_FIREPERIMETER',"");
DEFINE('_GIS_SETDEFAULTVIEW',"Poslavi kao standarni ekran");
DEFINE('_GIS_SETDEFAULTVIEW_DESCRIPTION',"");
DEFINE('_GIS_LOGOUT',"Odjava");
DEFINE('_GIS_LANGUAGE_CHANGE',"Jezik");
DEFINE('_GIS_LANGUAGE_EDIT',"Edit jezik");
DEFINE('_GIS_ADDPERIMETER',"Dodaj linije požara");
DEFINE('_GIS_ADDPERIMETER_DESCRIPTION',"");
DEFINE('_GIS_CLEARPERIMETER',"Izbriši linije požara");
DEFINE('_GIS_CLEARPERIMETER_DESCRIPTION',"");
DEFINE('_GIS_IGNITION_TYPE',"");
DEFINE('_GIS_POINT_IGNITION',"");
DEFINE('_GIS_PERIMETER_IGNITION',"");
DEFINE('_GIS_PERIMETER_IGNITION_SHORT',"");
DEFINE('_GIS_MODEL_SHORT_SCOTT_DFLT',"");
DEFINE('_GIS_MODEL_SHORT_ALBINI_DFLT',"");
DEFINE('_GIS_MODEL_SHORT_SCOTT_CSTM',"");
DEFINE('_GIS_MODEL_SHORT_ALBINI_CSTM',"");
DEFINE('_GIS_BARRIERS_CANNOT_BE_USED_CURRENT',"");
DEFINE('_GIS_OSMMAP',"");
DEFINE('_GIS_PRECIP',"Padaline");
DEFINE('_GIS_FWI',"FWI");
DEFINE('_GIS_MOISTURE_GENERAL',"Moisture");
DEFINE('_GIS_WIND_GENERAL',"Wind");
DEFINE('_GIS_SLOPE',"Slope");
DEFINE('_GIS_ROSBASE',"The perpendicular Rate of spread");
DEFINE('_GIS_ROSMAX',"The maximum Rate of spread");
DEFINE('_GIS_ROSMAXDIR',"The direction of the maximum ROS");
DEFINE('_GIS_DEGREES_SHORT',"deg");
DEFINE('_GIS_PARAMETRI_WIND_REDUCTION',"Parametri redukcije vjetra");
DEFINE('_GIS_WIND_REDUCTION_VALUE',"Koeficijent redukcije vjetra");
DEFINE('_GIS_CUSTOM',"vlastiti");
DEFINE('_GIS_HEMMLAN',"Hellmanov koeficijent");
/* SECTION_END */

/* SECTION_START( Fuel Models | Modeli goriva |) */
DEFINE('_FUEL_MODEL_PARAMETERS',"");
DEFINE('_FILTER',"");
DEFINE('_SORT',"");
DEFINE('_SAVE',"");
DEFINE('_RESET',"");
DEFINE('_IMPORT',"");
DEFINE('_EXPORT',"");
DEFINE('_ASCENDING',"");
DEFINE('_DESCENDING',"");
DEFINE('_SAVE_ALL',"");
DEFINE('_FUEL_ALBINI',"");
DEFINE('_FUEL_SCOTT',"");
DEFINE('_FUEL_MODEL_TYPE',"");
DEFINE('_FUEL_1H_FUEL_LOAD',"");
DEFINE('_FUEL_10H_FUEL_LOAD',"");
DEFINE('_FUEL_100H_FUEL_LOAD',"");
DEFINE('_FUEL_LIVE_HERB_FUEL_LOAD',"");
DEFINE('_FUEL_LIVE_WOODY_FUEL_LOAD',"");
DEFINE('_FUEL_1H_SURFACE_AREAVOLUME_RATIO',"");
DEFINE('_FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO',"");
DEFINE('_FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO',"");
DEFINE('_FUEL_BED_DEPTH',"");
DEFINE('_FUEL_DEAD_MOIS_EXTINCT',"");
DEFINE('_FUEL_DEAD_HEAT_CONT',"");
DEFINE('_FUEL_LIVE_HEAT_CONT',"");
DEFINE('_UNIT_TONS',"");
DEFINE('_UNIT_AC',"");
DEFINE('_UNIT_FT',"");
DEFINE('_UNIT_PERCENT',"");
DEFINE('_UNIT_BTULIB',"");
DEFINE('_FUEL_ANDERSON_01',"");
DEFINE('_FUEL_ANDERSON_02',"");
DEFINE('_FUEL_ANDERSON_03',"");
DEFINE('_FUEL_ANDERSON_04',"");
DEFINE('_FUEL_ANDERSON_05',"");
DEFINE('_FUEL_ANDERSON_06',"");
DEFINE('_FUEL_ANDERSON_07',"");
DEFINE('_FUEL_ANDERSON_08',"");
DEFINE('_FUEL_ANDERSON_09',"");
DEFINE('_FUEL_ANDERSON_10',"");
DEFINE('_FUEL_ANDERSON_11',"");
DEFINE('_FUEL_ANDERSON_12',"");
DEFINE('_FUEL_ANDERSON_13',"");
DEFINE('_FUEL_SCOTT_00-1',"NB1-Urban or suburban development");
DEFINE('_FUEL_SCOTT_00-2',"NB2-Snow/ice");
DEFINE('_FUEL_SCOTT_00-3',"NB3-Agricultural field, maintained in nonburnable condition ");
DEFINE('_FUEL_SCOTT_00-4',"NB8-Open water ");
DEFINE('_FUEL_SCOTT_00-5',"NB9-Bare ground ");
DEFINE('_FUEL_SCOTT_01',"GR1-Short, sparse dry climate grass");
DEFINE('_FUEL_SCOTT_02',"GR2-Low load, dry climate grass");
DEFINE('_FUEL_SCOTT_03',"GR3-Low load, very coarse, humid climate grass");
DEFINE('_FUEL_SCOTT_04',"GR4-Moderate load, dry climate grass");
DEFINE('_FUEL_SCOTT_05',"GR5-Low load, humid climate grass");
DEFINE('_FUEL_SCOTT_06',"GR6-Moderate load, humid climate grass");
DEFINE('_FUEL_SCOTT_07',"GR7-High load dry climate grass");
DEFINE('_FUEL_SCOTT_08',"GR 8-High load, very coarse, humid climate grass");
DEFINE('_FUEL_SCOTT_09',"GR 9-Very high load humid climate grass");
DEFINE('_FUEL_SCOTT_10',"GS1-Low load, dry climate grass-shrub");
DEFINE('_FUEL_SCOTT_11',"GS2-Moderate load, dry climate grass-shrub");
DEFINE('_FUEL_SCOTT_12',"GS3-Moderate load, humid climate grass-shrub");
DEFINE('_FUEL_SCOTT_13',"GS4-High load humid climate grass-shrub");
DEFINE('_FUEL_SCOTT_14',"SH1-Low load, dry climate shrub");
DEFINE('_FUEL_SCOTT_15',"SH2-Moderate load, dry climate shrub");
DEFINE('_FUEL_SCOTT_16',"SH3-Moderate load, humid climate shrub");
DEFINE('_FUEL_SCOTT_17',"SH4-Low load, humid climate, timber-shrub");
DEFINE('_FUEL_SCOTT_18',"SH5-High load, dry climate shrub");
DEFINE('_FUEL_SCOTT_19',"SH6-Low load, humid climate shrub");
DEFINE('_FUEL_SCOTT_20',"SH7-Very high load, dry climate shrub");
DEFINE('_FUEL_SCOTT_21',"SH8-High load, humid climate shrub");
DEFINE('_FUEL_SCOTT_22',"SH9-Very high load, humid climate shrub");
DEFINE('_FUEL_SCOTT_23',"TU1-Light load, dry climate timber-grass-shrub");
DEFINE('_FUEL_SCOTT_24',"TU2-Moderate load, humid climate timber-shrub");
DEFINE('_FUEL_SCOTT_25',"TU3-Moderate load, humid climate timber-grass-shrub");
DEFINE('_FUEL_SCOTT_26',"TU4-Dwarf conifer with understory");
DEFINE('_FUEL_SCOTT_27',"TU5-Very high load, dry climate timber-shrub");
DEFINE('_FUEL_SCOTT_28',"TL1-Low load, compact conifer litter");
DEFINE('_FUEL_SCOTT_29',"TL2-Low load, broadleaf litter");
DEFINE('_FUEL_SCOTT_30',"TL3-Moderate load, conifer litter");
DEFINE('_FUEL_SCOTT_31',"TL4-Small downed logs");
DEFINE('_FUEL_SCOTT_32',"TL5-High load, conifer litter");
DEFINE('_FUEL_SCOTT_33',"TL6-Moderate load, broadleaf litter");
DEFINE('_FUEL_SCOTT_34',"TL7-Large downed logs");
DEFINE('_FUEL_SCOTT_35',"TL8-Long-needle litter");
DEFINE('_FUEL_SCOTT_36',"TL9-Very high, load broadleaf litter");
DEFINE('_FUEL_SCOTT_37',"SB1-Low load activity fuel");
DEFINE('_FUEL_SCOTT_38',"SB2-Moderate load activity or low load blowdown");
DEFINE('_FUEL_SCOTT_39',"SB3-High load activity fuel or moderate load blowdown");
DEFINE('_FUEL_SCOTT_40',"SB4-High load blowdown");
DEFINE('_FUEL_BACK_TO_TOP',"");
DEFINE('_FUEL_STATUS_ALBINI_RESET',"");
DEFINE('_WIND_STATUS_RESET_COMPLETE',"");
DEFINE('_FUEL_STATUS_SCOTT_RESET',"");
DEFINE('_FUEL_STATUS_RESET',"");
DEFINE('_WIND_STATUS_RESET',"");
DEFINE('_FUEL_STATUS_RESET_CANCELLED',"");
DEFINE('_FUEL_STATUS_SAVE',"");
DEFINE('_WIND_STATUS_SAVE',"");
DEFINE('_FUEL_STATUS_SAVE_CANCELLED',"");
DEFINE('_FUEL_STATUS_NOT_SAVED',"");
DEFINE('_FUEL_STATUS_SAVED',"");
DEFINE('_FUEL_ENTER_FILENAME',"");
DEFINE('_FUEL_STATUS_EXPORT_DONE',"");
DEFINE('_FUEL_STATUS_EXPORT_CANCELLED',"");
DEFINE('_FUEL_STATUS_NO_FILE_CHOSEN',"");
DEFINE('_FUEL_STATUS_ERROR_NUMBER_CAT',"");
DEFINE('_COMPLETED_WITH_ERRORS',"");
DEFINE('_CONTINUE_IN_BCK',"");
DEFINE('_FUEL_STATUS_FUEL_IMPORTED',"");
DEFINE('_PRJ_ERROR',"");
DEFINE('_METEO_ERROR',"");
/* SECTION_END */
?>
