#!/bin/sh

g.region rast=aspect@WebGis res=200

g.remove rast=wind_eruptive_speed,wind_eruptive_dir,eruptive_risk,aspect_newTemp,wind_parameter,wind_correction
echo "Calculate eruptive risk:"
#r.in.arc input=/home/holistic/meteoArhiva/current/wind_dir.asc output=wind_eruptive_dir type=FCELL mult=1.0
r.in.arc input=/home/holistic/meteoArhiva/current/wind_dir.asc output=wind_eruptive_dir type=FCELL mult=1.0
r.in.arc input=/home/holistic/meteoArhiva/current/wind_speed.asc output=wind_eruptive_speed type=FCELL mult=1.0
g.region rast=wind_eruptive_speed
r.mapcalc wind_eruptive_dir="((-wind_eruptive_dir+90)+360)%360"
#Prebacivanje iz km/h u m/s
r.mapcalc wind_eruptive_speed=wind_eruptive_speed*0.27778
#Prvi dio prebacivanja u wind_reduction
r.mapcalc wind_eruptive_speed=wind_eruptive_speed*0.87
#Drugi dio prebacivanja
r.reclass input=modelAlbini@WebGis --overwrite output=wind_correction rules=/home/holistic/webapp/gis_spread_split/userdefault/reclass_WindCorrection.r
r.mapcalc wind_eruptive_speed=wind_eruptive_speed*wind_correction/100
g.remove rast=wind_correction
#Gotovo wind reduction

g.region rast=aspect@WebGis res=200


#Brisi
#r.mapcalc eruptive_risk="(1-((abs(((( abs((aspect@WebGis+360)%360) - abs((wind_eruptive_dir+360)%360) ) + 180) % 360)-180))/180))*255"
#r.what input=aspect@WebGis,wind_eruptive_dir,eruptive_risk east_north=1973568.4600318,5408754.2168857
#echo '0 green\n255 red\nend' | r.colors map=eruptive_risk color=rules rules=-
#r.out.tiff input=eruptive_risk output="/home/holistic/meteoArhiva/current/eruptive_risk" compression=none -t
#Brisi


#Prva kategorija
r.mapcalc eruptive_risk="if(slope@WebGis>25,1,null())";


#Izracunaj najmanji kut ((A - B) + 180) % 360 - 180 pa normaliziraj u 0,1 pa obrni
r.mapcalc rWDA="(1-((abs(((( abs((aspect@WebGis+360)%360) - abs((wind_eruptive_dir+360)%360) ) + 180) % 360)-180))/180))"
r.mapcalc k="if(slope@WebGis<=20,0, if(slope@WebGis>20 && slope@WebGis<=40,1, if(slope@WebGis>40 && slope@WebGis<=60,2, if(slope@WebGis>60,3, null()))))"
r.mapcalc MFWSS="wind_eruptive_speed+wind_eruptive_speed*k"
r.mapcalc MFWSSA = "MFWSS*rWDA"

#Druga kategorija
r.mapcalc eruptive_risk="if(wind_eruptive_speed>2 && MFWSSA>2,2,eruptive_risk)";
#Treca kategorija
r.mapcalc eruptive_risk="if(wind_eruptive_speed>2 && MFWSSA>2 && aspect@WebGis>135 && aspect@WebGis < 225,3,eruptive_risk)";
#Cetvrta kategorija // Trebat ce popravit ovdje Scott burgana
r.mapcalc eruptive_risk="if(wind_eruptive_speed>2 && MFWSSA>2 && aspect@WebGis>135 && aspect@WebGis < 225 && ((modelAlbini@WebGis > 0 && modelAlbini@WebGis < 6 ) || (modelScott@WebGis > 0 && modelScott@WebGis < 22)),4,eruptive_risk)";

echo '0 255:255:255\n1 254:130:122\n2 255:101:77\n3 254:45:0\n4 181:30:0\n5 255:255:255\n100 255:255:255\nend' | r.colors map=eruptive_risk color=rules rules=-
r.out.tiff input=eruptive_risk output="/home/holistic/meteoArhiva/current/eruptive_risk" compression=none -t





