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
DEFINE('_NATPIS_EU',"This project was partly financed by the European Union.<br />The content of this website does not reflect the official opinion of the European Union.");
DEFINE('_NATPIS_TITLE',"AdriaFirePropagator");
DEFINE('_NATPIS_COPYRIGHT',"Copyright (c) 2015");
DEFINE('_NATPIS_DESCRIPTION',"AdriaFirePropagator.");
DEFINE('_NATPIS_KEYWORDS',"forest fires, early detection, forest fire simulation");
DEFINE('_NATPIS_PRICEKAJTE',"Please wait!");
DEFINE('_NATPIS_UPOZORENJE',"HOLISTIC programme is co-funded bu the EUROPEAN UNION, Instrument for Pre-Accession Asistence. <br />The content of this website does not reflect the official opinion of the European Union.<br /><br />The system may only be used by authorized users. Attempts at unauthorized access are criminal offenses.<br />Upon entering login and password the user is redirected to the application level for which he has authorization.");
DEFINE('_NATPIS_DISCLAIMER',"<b style=\"color:red\">DISCLAIMER:</b><br />AdriaFirePropagator is being developed at the Faculty of Electrical Engineering, Mechanical Engineering and Naval Architecture <br />University of Split as a part of the IPA Holistic Project.<br />AdriaFirePropagator is an experimental system. The developers assume no responsibility whatsoever for its use by other parties,<br /> and makes no guarantees, expressed or implied, about its quality, accuracy, reliability or any other characteristic.<br /> We would appreciate acknowledgement if the software is used. <br /><b style=\"color:red\">By entering this site you acknowledge and agree to this legal disclaimer. If you do not agree to this, do not use the site.</b><br /><br />Recommended resolution: HD 1080 (1920 x 1080 px) - Minimum resolution: HD 720 (1280 x 720 px)");
DEFINE('_NATPIS_REGISTRIRANI_KORISNICI',"Registered users");
DEFINE('_NATPIS_IDENTIFIKACIJA',"Username");
DEFINE('_NATPIS_ZAPORKA',"Password");
DEFINE('_NATPIS_POTVRDA',"Enter");
DEFINE('_NATPIS_POTVRDA_TITLE',"Click to start the AdriaFirePropagator");
DEFINE('_NATPIS_WRONG_LOGIN',"Wrong Login Data");
DEFINE('_NATPIS_NO_LOGIN',"You must be logged, so first go to <a href=\"http://propagator.adriaholistic.eu\">LOGIN PAGE</a>");
/* SECTION_END */

/* SECTION_START( Main | Osnovno ) */
DEFINE('_GIS_OK',"OK");
DEFINE('_GIS_CANCEL',"Cancel");
DEFINE('_GIS_USER',"User");
DEFINE('_GIS_USER_ADMIN',"Admin Users");
DEFINE('_GIS_ARESURE',"Are you sure?");
DEFINE('_GIS_CORINE_LEGENDA',"CORINE");
DEFINE('_GIS_CORINE_LEGENDA_DESCRIPTION',"Detailed description of CORINE classes");
DEFINE('_GIS_RUNNING',"Running ...");
DEFINE('_GIS_RUNNING_FIRST',"Welcome back, ");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI',"Transparency");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI_DESCRIPTION',"Adjust transparency for all layers");
DEFINE('_GIS_KONTROLA_PROZIRNOSTI_SLOJEVA',"Layer transparency control");
DEFINE('_GIS_UKLJUCI',"Enable");
DEFINE('_GIS_ISKLJUCI',"Disable");
DEFINE('_GIS_NIJE_OMOGUCENO',"Not available");
DEFINE('_GIS_OSNOVNI_SLOJEVI',"Base layers");
DEFINE('_GIS_OSTALI_SLOJEVI',"Other layers");
DEFINE('_GIS_GOOGLE_PHYSICAL',"Google relief");
DEFINE('_GIS_GOOGLE_STREETS_',"Google streets");
DEFINE('_GIS_GOOGLE_HYBRID',"Google hybrid");
DEFINE('_GIS_GOOGLE_SATELLITE',"Google satellite");
DEFINE('_GIS_VJETAR_TRENUTNI',"Wind - current");
DEFINE('_GIS_VJETAR_VLASTITI',"Wind - custom");
DEFINE('_GIS_VEGETACIJA',"Vegetation: Corine");
DEFINE('_GIS_MODEL_ALBINI',"Vegetation: Albini-Anderson - custom");
DEFINE('_GIS_MODEL_SCOTT',"Vegetation: Scott-Burgan - custom");
DEFINE('_GIS_MODEL_ALBINI_DEFAULT',"Vegetation: Albini-Anderson - default");
DEFINE('_GIS_MODEL_SCOTT_DEFAULT',"Vegetation: Scott-Burgan - default");
DEFINE('_GIS_POZAR_RASTER',"Fire simulation result (raster)");
DEFINE('_GIS_POZAR_VECTOR',"Fire simulation result (vector)");
DEFINE('_GIS_LAT_LON_KOORDINATE',"Coordinates (lon-lat)");
DEFINE('_GIS_KOORDINATE_TOCKE',"Point coordinates:");
DEFINE('_GIS_KOORDINATE_SJEVER',"N");
DEFINE('_GIS_KOORDINATE_ISTOK',"E");
DEFINE('_GIS_SIMULACIJA',"Simulation");
DEFINE('_GIS_TRENUTNA_SIMULACIJA',"Start simulation (current)");
DEFINE('_GIS_VLASTITA_SIMULACIJA',"Start simulation (custom)");
DEFINE('_GIS_POSTAVKE_S',"Settings");
DEFINE('_GIS_POSTAVKE_SIMULACIJE',"Simulation properties");
DEFINE('_GIS_VLASTITI_PARAM_VJETAR',"Custom parameters (wind)");
DEFINE('_GIS_VLASTITI_PARAM_VLAGA',"Custom parameters (moisture)");
DEFINE('_GIS_CALCROS_VLATITI',"Calculate ROS (custom)");
DEFINE('_GIS_POZARNAFRONTA_START',"Fire front (start)");
DEFINE('_GIS_POZARNAFRONTA_STOP',"Fire front (stop)");
DEFINE('_GIS_VRIJEME',"Time");
DEFINE('_GIS_KORAK',"Timestep");
DEFINE('_GIS_QUA_SPEED',"Quality/Speed");
DEFINE('_GIS_PARAMETRI_GORIVA',"Fuel parameters");
DEFINE('_GIS_FUEL_MAP_MANAGE',"Calculate fuel maps");
DEFINE('_TIME_MIN',"Time (min)");
DEFINE('_TIMESTEP_MIN',"Timestep (min)");
DEFINE('_SIMULATION_SPEED',"Speed");
DEFINE('_SIMULATION_QUALITY',"Quality");
DEFINE('_SIMULATION_ANIMATION_QUE',"Animated simulation?");
DEFINE('_WIND_PROPERTIES',"WIND PROPERTIES");
DEFINE('_WIND_FORECAST_HOUR',"Forecast (hour):");
DEFINE('_WIND_HOUR',"Hour:");
DEFINE('_PARAMETERS_ASC',"ASC");
DEFINE('_PARAMETERS_BY_DATE',"By date");
DEFINE('_GET_WIND_ONLINE',"Get on-line wind parameters");
DEFINE('_GET_METEO',"Meteo");
DEFINE('_GET_FILE_COLON',"File:");
DEFINE('_DIRECTION_COLON',"Direction:");
DEFINE('_SPEED_COLON',"Speed:");
DEFINE('_DIRECTION',"Direction");
DEFINE('_WIND_DATE',"Date:");
DEFINE('_SPEED',"Speed");
DEFINE('_VALUE',"Value");
DEFINE('_UPDATE_WIND_SETTINGS',"Update wind settings");
DEFINE('_UPDATE_STILL_WORKING',"Please wait! Still working");
DEFINE('_MOIS_PROPERTIES',"MOISTURE PROPERTIES");
DEFINE('_GET_MOIS_ONLINE',"Get on-line moisture parameters");
DEFINE('_GET_MOIS_LIVE',"mois_live:");
DEFINE('_GET_MOIS_1H',"mois1h:");
DEFINE('_GET_MOIS_10H',"mois10h:");
DEFINE('_GET_MOIS_100H',"mois100h:");
DEFINE('_GIS_MOIS_LIVE',"Moisture (live)");
DEFINE('_GIS_MOIS_LIVE_CUSTOM',"Moisture (live) - custom");
DEFINE('_PARAMETERS_ONLINE',"On-line");
DEFINE('_UPDATE_MOIS_SETTINGS',"Update moisture settings");
DEFINE('_GIS_UNSUCCESSFUL_ATTEMPT',"Unsuccessful attempt");
DEFINE('_GIS_DATA_INCOMPLETE',"Incomplete data");
DEFINE('_GIS_DATA_MISSING',"Data missing");
DEFINE('_GIS_SUCCESS',"Success");
DEFINE('_GIS_WIND_SUCCESS',"Wind updated successfully");
DEFINE('_GIS_MOIS_SUCCESS',"Moisture updated successfully");
DEFINE('_GIS_PLS_RUN_ROS',"Please re-run Calculate ROS");
DEFINE('_GIS_MIRIP',"AdriaFireRisk");
DEFINE('_GIS_CHOSEN_FUEL_MODEL',"Chosen fuel model:");
DEFINE('_GIS_ALBINI_CUSTOM',"Albini-Anderson (custom)");
DEFINE('_GIS_SCOTT_CUSTOM',"Scott-Burgan (custom)");
DEFINE('_GIS_ALBINI_DEFAULT',"Albini-Anderson (default)");
DEFINE('_GIS_SCOTT_DEFAULT',"Scott-Burgan (default)");
DEFINE('_GIS_CHOSEN_FUEL_MODEL_SHORT',"Fuel model:");
DEFINE('_GIS_FUEL_DIALOG',"Fuel maps are not found! It is recommended that you begin the calculation now. Please note that simulation might not be available before this process is finished. Do you want to start the calculation now?");
DEFINE('_GIS_FUEL_DIALOG_MANUAL',"Are you sure you want to (re)-calculate custom fuel maps! Please note that simulation might not be available before this process is finished. Do you want to start the calculation now?");
DEFINE('_GIS_FUEL_DIALOG_DEFAULT',"DEFAULT fuel maps are not found! Please contact the administrator");
DEFINE('_GIS_FUEL_FAILURE',"Fuel maps calculation not working as expected. The reason might be large files. Please, reload AdriaFirePropagator and check if calculation is still running. If not, please contact the administrator!");
DEFINE('_GIS_FUEL_STILL_RUNNING',"Still running fuel maps preparation! Simulations might not be available!");
DEFINE('_GIS_NORESULTS_SIMULATION',"Last simulation has returned EMPTY results (could be no fire)!");
DEFINE('_GIS_NOT_SUPPORTED',"Not yet supported!");
DEFINE('_GIS_ERUPTIVERISK',"Eruptive fire risk");
DEFINE('_GIS_ADDFIREBARRIER',"Add fire barriers");
DEFINE('_GIS_ADDFIREBARRIER_DESCRIPTION',"Fire barriers represent areas NOT affected by fire. Start drawing the area by left-clicking somewhere on the map and finish drawing with a double-click.");
DEFINE('_GIS_CLEARIREBARRIER',"Clear fire barriers");
DEFINE('_GIS_CLEARIREBARRIER_DESCRIPTION',"Removes ALL drawn fire barriers from the map!");
DEFINE('_GIS_STOPPREVIOUSCALCS',"Terminate");
DEFINE('_GIS_STOPPREVIOUSCALCS_DESCRIPTION',"Force termination of all previous calculations initiated by the user. To be used only if necessary!");
DEFINE('_GIS_REFRESHALLLAYERS',"Refresh");
DEFINE('_GIS_REFRESHALLLAYERS_DESCRIPTION',"Force refresh all visible layers");
DEFINE('_GIS_PREVIOUSMETEOCALCSERROR',"Meteo data not yet obtained! Please wait!");
DEFINE('_GIS_PREVIOUSCALCSERROR',"Previous calculations still running! Please wait!");
DEFINE('_GIS_PREVIOUSSIMSERROR',"Previous calculations still running! Please wait!");
DEFINE('_GIS_STOPPREVIOUSCALCS_QUES',"Are you sure you want to terminate any previous calculations? Web page will become unresponsive for a few moments.");
DEFINE('_GIS_FIREBARRIER',"Fire barrier(s)");
DEFINE('_GIS_FIREPERIMETER',"Fire front");
DEFINE('_GIS_SETDEFAULTVIEW',"Set as default");
DEFINE('_GIS_SETDEFAULTVIEW_DESCRIPTION',"Current view is saved as default! Next time the application is opened the view will be the same as now!");
DEFINE('_GIS_LOGOUT',"Logout");
DEFINE('_GIS_LANGUAGE_CHANGE',"Language");
DEFINE('_GIS_LANGUAGE_EDIT',"Edit Language");
DEFINE('_GIS_ADDPERIMETER',"Add fire front");
DEFINE('_GIS_ADDPERIMETER_DESCRIPTION',"Fire fronts represent areas already affected by the fire and can be treated as ignition points. Start drawing the area by left-clicking somewhere on the map and finish drawing with a double-click.");
DEFINE('_GIS_CLEARPERIMETER',"Clear fire front");
DEFINE('_GIS_CLEARPERIMETER_DESCRIPTION',"Removes ALL drawn fire fronts from the map!");
DEFINE('_GIS_IGNITION_TYPE',"Ignition type:");
DEFINE('_GIS_POINT_IGNITION',"Point");
DEFINE('_GIS_PERIMETER_IGNITION',"Fire front");
DEFINE('_GIS_PERIMETER_IGNITION_SHORT',"Front");
DEFINE('_GIS_MODEL_SHORT_SCOTT_DFLT',"Scott (dflt)");
DEFINE('_GIS_MODEL_SHORT_ALBINI_DFLT',"Albini (dflt)");
DEFINE('_GIS_MODEL_SHORT_SCOTT_CSTM',"Scott (cstm)");
DEFINE('_GIS_MODEL_SHORT_ALBINI_CSTM',"Albini (cstm)");
DEFINE('_GIS_BARRIERS_CANNOT_BE_USED_CURRENT',"Fire barriers will be ignored when using current simulation!");
DEFINE('_GIS_OSMMAP',"Open street map");
DEFINE('_GIS_PRECIP',"Precipitation");
DEFINE('_GIS_FWI',"FWI");
DEFINE('_GIS_MOISTURE_GENERAL',"Moisture");
DEFINE('_GIS_WIND_GENERAL',"Wind");
DEFINE('_GIS_SLOPE',"Slope");
DEFINE('_GIS_ROSBASE',"The perpendicular Rate of spread");
DEFINE('_GIS_ROSMAX',"The maximum Rate of spread");
DEFINE('_GIS_ROSMAXDIR',"The direction of the maximum ROS");
DEFINE('_GIS_DEGREES_SHORT',"deg");
DEFINE('_GIS_PARAMETRI_WIND_REDUCTION',"Wind reduction parameters");
DEFINE('_GIS_WIND_REDUCTION_VALUE',"Wind reduction coefficient");
DEFINE('_GIS_CUSTOM',"custom");
DEFINE('_GIS_HEMMLAN',"Hellman coefficient");
/* SECTION_END */

/* SECTION_START( Fuel Models | Modeli goriva ) */
DEFINE('_FUEL_MODEL_PARAMETERS',"Fuel model parameters");
DEFINE('_FILTER',"Filter:");
DEFINE('_SORT',"Sort");
DEFINE('_SAVE',"Save");
DEFINE('_RESET',"Reset");
DEFINE('_IMPORT',"Import");
DEFINE('_EXPORT',"Export");
DEFINE('_ASCENDING',"Asc");
DEFINE('_DESCENDING',"Desc");
DEFINE('_SAVE_ALL',"Save (all)");
DEFINE('_FUEL_ALBINI',"Albini & Anderson's");
DEFINE('_FUEL_SCOTT',"Scott & Burgan's");
DEFINE('_FUEL_MODEL_TYPE',"Fuel Model Type");
DEFINE('_FUEL_1H_FUEL_LOAD',"1-h Fuel Load");
DEFINE('_FUEL_10H_FUEL_LOAD',"10-h Fuel Load");
DEFINE('_FUEL_100H_FUEL_LOAD',"100-h Fuel Load");
DEFINE('_FUEL_LIVE_HERB_FUEL_LOAD',"Live Herbaceous Fuel Load");
DEFINE('_FUEL_LIVE_WOODY_FUEL_LOAD',"Live Woody Fuel Load");
DEFINE('_FUEL_1H_SURFACE_AREAVOLUME_RATIO',"1-h Surface Area/Vol Ratio");
DEFINE('_FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO',"Live Herbaceous Surface Area/Vol Ratio");
DEFINE('_FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO',"Live Woody Surface Area/Vol Ratio");
DEFINE('_FUEL_BED_DEPTH',"Fuel Bed Depth");
DEFINE('_FUEL_DEAD_MOIS_EXTINCT',"Dead Fuel Moisture of Extinction");
DEFINE('_FUEL_DEAD_HEAT_CONT',"Dead Fuel Heat Content");
DEFINE('_FUEL_LIVE_HEAT_CONT',"Live Fuel Heat Content");
DEFINE('_UNIT_TONS',"tons");
DEFINE('_UNIT_AC',"ac");
DEFINE('_UNIT_FT',"ft");
DEFINE('_UNIT_PERCENT',"percent");
DEFINE('_UNIT_BTULIB',"Btu/lb");
DEFINE('_FUEL_ANDERSON_01',"Short Grass");
DEFINE('_FUEL_ANDERSON_02',"Timber grass and understory");
DEFINE('_FUEL_ANDERSON_03',"Tall grass");
DEFINE('_FUEL_ANDERSON_04',"Chaparral");
DEFINE('_FUEL_ANDERSON_05',"Brush");
DEFINE('_FUEL_ANDERSON_06',"Dormant brush, hardwood slash");
DEFINE('_FUEL_ANDERSON_07',"Southern rough");
DEFINE('_FUEL_ANDERSON_08',"Short needle litter");
DEFINE('_FUEL_ANDERSON_09',"Long needle or hardwood litter");
DEFINE('_FUEL_ANDERSON_10',"Timber litter & understory");
DEFINE('_FUEL_ANDERSON_11',"Light logging slashLight logging slash");
DEFINE('_FUEL_ANDERSON_12',"Medium logging slash");
DEFINE('_FUEL_ANDERSON_13',"Heavy logging slash");
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
DEFINE('_FUEL_BACK_TO_TOP',"Back to Top");
DEFINE('_FUEL_STATUS_ALBINI_RESET',"Albini-Anderson data reset");
DEFINE('_WIND_STATUS_RESET_COMPLETE',"Wind reduction data reset complete");
DEFINE('_FUEL_STATUS_SCOTT_RESET',"Scott-Burgan data reset");
DEFINE('_FUEL_STATUS_RESET',"Do you want to reset fuel model values to default! All previous changes will be lost!");
DEFINE('_WIND_STATUS_RESET',"Do you want to reset wind reduction parameters to default! All previous changes will be lost!");
DEFINE('_FUEL_STATUS_RESET_CANCELLED',"Reset cancelled!");
DEFINE('_FUEL_STATUS_SAVE',"Do you want to save all the changes to both fuel models?");
DEFINE('_WIND_STATUS_SAVE',"Do you want to save all the changes?");
DEFINE('_FUEL_STATUS_SAVE_CANCELLED',"Save cancelled!");
DEFINE('_FUEL_STATUS_NOT_SAVED',"Changes not saved!");
DEFINE('_FUEL_STATUS_SAVED',"Changes saved!");
DEFINE('_FUEL_ENTER_FILENAME',"Please enter the filename");
DEFINE('_FUEL_STATUS_EXPORT_DONE',"Fuel file export done!");
DEFINE('_FUEL_STATUS_EXPORT_CANCELLED',"Fuel file export cancelled!");
DEFINE('_FUEL_STATUS_NO_FILE_CHOSEN',"No file chosen!");
DEFINE('_FUEL_STATUS_ERROR_NUMBER_CAT',"Fuel file FAILED to import! (Incorrect number of categories!)");
DEFINE('_COMPLETED_WITH_ERRORS',"Completed with ERRORS");
DEFINE('_CONTINUE_IN_BCK',"Communication with meteo server will continue in the background. Data will appear when obtained! This can take a few minutes!");
DEFINE('_FUEL_STATUS_FUEL_IMPORTED',"Fuel file imported!");
DEFINE('_PRJ_ERROR',"Prj file repaired to fit EPSG:900913 in ");
DEFINE('_METEO_ERROR',"Problem with obtaining meteo files. Please contact administrator!");
/* SECTION_END */
?>