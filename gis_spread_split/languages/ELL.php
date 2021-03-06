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
DEFINE('_NATPIS_CHARSET',"");
/* SECTION_END */

/* SECTION_START( Acknowledgement | Potvrda ) */
DEFINE('_NATPIS_FOOTER',"");
DEFINE('_NATPIS_EU',"");
DEFINE('_NATPIS_TITLE',"");
DEFINE('_NATPIS_COPYRIGHT',"");
DEFINE('_NATPIS_DESCRIPTION',"");
DEFINE('_NATPIS_KEYWORDS',"");
DEFINE('_NATPIS_PRICEKAJTE',"");
DEFINE('_NATPIS_UPOZORENJE',"");
DEFINE('_NATPIS_DISCLAIMER',"");
DEFINE('_NATPIS_REGISTRIRANI_KORISNICI',"");
DEFINE('_NATPIS_IDENTIFIKACIJA',"");
DEFINE('_NATPIS_ZAPORKA',"");
DEFINE('_NATPIS_POTVRDA',"");
DEFINE('_NATPIS_POTVRDA_TITLE',"");
DEFINE('_NATPIS_WRONG_LOGIN',"");
DEFINE('_NATPIS_NO_LOGIN',"");
/* SECTION_END */

/* SECTION_START( Main | Osnovno ) */
DEFINE('_GIS_OK',"");
DEFINE('_GIS_CANCEL',"");
DEFINE('_GIS_USER',"");
DEFINE('_GIS_USER_ADMIN',"");
DEFINE('_GIS_ARESURE',"");
DEFINE('_GIS_CORINE_LEGENDA',"");
DEFINE('_GIS_CORINE_LEGENDA_DESCRIPTION',"");
DEFINE('_GIS_RUNNING',"");
DEFINE('_GIS_RUNNING_FIRST',"");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI',"");
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
DEFINE('_GIS_ADDFIREBARRIER',"");
DEFINE('_GIS_ADDFIREBARRIER_DESCRIPTION',"");
DEFINE('_GIS_CLEARIREBARRIER',"");
DEFINE('_GIS_CLEARIREBARRIER_DESCRIPTION',"");
DEFINE('_GIS_STOPPREVIOUSCALCS',"");
DEFINE('_GIS_STOPPREVIOUSCALCS_DESCRIPTION',"");
DEFINE('_GIS_REFRESHALLLAYERS',"");
DEFINE('_GIS_REFRESHALLLAYERS_DESCRIPTION',"");
DEFINE('_GIS_PREVIOUSMETEOCALCSERROR',"");
DEFINE('_GIS_PREVIOUSCALCSERROR',"");
DEFINE('_GIS_PREVIOUSSIMSERROR',"");
DEFINE('_GIS_STOPPREVIOUSCALCS_QUES',"");
DEFINE('_GIS_FIREBARRIER',"");
DEFINE('_GIS_FIREPERIMETER',"");
DEFINE('_GIS_SETDEFAULTVIEW',"");
DEFINE('_GIS_SETDEFAULTVIEW_DESCRIPTION',"");
DEFINE('_GIS_LOGOUT',"");
DEFINE('_GIS_LANGUAGE_CHANGE',"");
DEFINE('_GIS_LANGUAGE_EDIT',"");
DEFINE('_GIS_ADDPERIMETER',"");
DEFINE('_GIS_ADDPERIMETER_DESCRIPTION',"");
DEFINE('_GIS_CLEARPERIMETER',"");
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
DEFINE('_GIS_PRECIP',"");
DEFINE('_GIS_FWI',"");
DEFINE('_GIS_MOISTURE_GENERAL',"");
DEFINE('_GIS_WIND_GENERAL',"");
DEFINE('_GIS_SLOPE',"");
DEFINE('_GIS_ROSBASE',"");
DEFINE('_GIS_ROSMAX',"");
DEFINE('_GIS_ROSMAXDIR',"");
DEFINE('_GIS_DEGREES_SHORT',"");
DEFINE('_GIS_PARAMETRI_WIND_REDUCTION',"");
DEFINE('_GIS_WIND_REDUCTION_VALUE',"");
DEFINE('_GIS_CUSTOM',"");
DEFINE('_GIS_HEMMLAN',"");
/* SECTION_END */

/* SECTION_START( Fuel Models | Modeli goriva ) */
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
DEFINE('_FUEL_SCOTT_00-1',"");
DEFINE('_FUEL_SCOTT_00-2',"");
DEFINE('_FUEL_SCOTT_00-3',"");
DEFINE('_FUEL_SCOTT_00-4',"");
DEFINE('_FUEL_SCOTT_00-5',"");
DEFINE('_FUEL_SCOTT_01',"");
DEFINE('_FUEL_SCOTT_02',"");
DEFINE('_FUEL_SCOTT_03',"");
DEFINE('_FUEL_SCOTT_04',"");
DEFINE('_FUEL_SCOTT_05',"");
DEFINE('_FUEL_SCOTT_06',"");
DEFINE('_FUEL_SCOTT_07',"");
DEFINE('_FUEL_SCOTT_08',"");
DEFINE('_FUEL_SCOTT_09',"");
DEFINE('_FUEL_SCOTT_10',"");
DEFINE('_FUEL_SCOTT_11',"");
DEFINE('_FUEL_SCOTT_12',"");
DEFINE('_FUEL_SCOTT_13',"");
DEFINE('_FUEL_SCOTT_14',"");
DEFINE('_FUEL_SCOTT_15',"");
DEFINE('_FUEL_SCOTT_16',"");
DEFINE('_FUEL_SCOTT_17',"");
DEFINE('_FUEL_SCOTT_18',"");
DEFINE('_FUEL_SCOTT_19',"");
DEFINE('_FUEL_SCOTT_20',"");
DEFINE('_FUEL_SCOTT_21',"");
DEFINE('_FUEL_SCOTT_22',"");
DEFINE('_FUEL_SCOTT_23',"");
DEFINE('_FUEL_SCOTT_24',"");
DEFINE('_FUEL_SCOTT_25',"");
DEFINE('_FUEL_SCOTT_26',"");
DEFINE('_FUEL_SCOTT_27',"");
DEFINE('_FUEL_SCOTT_28',"");
DEFINE('_FUEL_SCOTT_29',"");
DEFINE('_FUEL_SCOTT_30',"");
DEFINE('_FUEL_SCOTT_31',"");
DEFINE('_FUEL_SCOTT_32',"");
DEFINE('_FUEL_SCOTT_33',"");
DEFINE('_FUEL_SCOTT_34',"");
DEFINE('_FUEL_SCOTT_35',"");
DEFINE('_FUEL_SCOTT_36',"");
DEFINE('_FUEL_SCOTT_37',"");
DEFINE('_FUEL_SCOTT_38',"");
DEFINE('_FUEL_SCOTT_39',"");
DEFINE('_FUEL_SCOTT_40',"");
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
