#!/bin/sh

g.remove rast=wind_eruptive_speed,wind_eruptive_dir,eruptive_risk,aspect_newTemp,wind_parameter
echo "Calculate eruptive risk:"
r.in.arc input=/home/holistic/meteoArhiva/current/wind_dir.asc output=wind_eruptive_dir type=FCELL mult=1.0
r.in.arc input=/home/holistic/meteoArhiva/current/wind_speed.asc output=wind_eruptive_speed type=FCELL mult=1.0
g.region rast=aspect@WebGis res=150

#Start3
#smjer vjetra treba odgovarat aspectu

#r.mapcalc wind_eruptive_dir=wind_eruptive_dir-180
#A namjestanje... pogledat dokumentaciju kakav je aspect a kakav wind dir
r.mapcalc wind_eruptive_dir="-(wind_eruptive_dir+90)+180"


#treba uzteti u obzir prklapanje, pa je max razlika 180, normalizirat od 0,1, sredit razliku u računanju stupnjeva...
r.mapcalc wind_parameter="(1-(((abs(((( aspect@WebGis-wind_eruptive_dir) + 180) % 360) - 180))/360)*2))*kopno@WebGis*wind_eruptive_speed"

#ako je slope + wind_parameter/2  vece od thresholda
r.mapcalc eruptive_risk="if(((slope@WebGis+(wind_parameter/3))/2)>15,255,null())";


#r.colors map=wind_parameter color=gyr
r.out.tiff input=eruptive_risk output="/home/holistic/meteoArhiva/current/eruptive_risk" compression=none -t 
g.remove rast=wind_eruptive_speed,wind_eruptive_dir,eruptive_risk,aspect_newTemp,wind_parameter
#r.out.tiff input=eruptive_risk output="/home/holistic/meteoArhiva/current/eruptive_risk" compression=none -t 
#r.out.ascii --overwrite input=eruptive_risk output=/home/holistic/meteoArhiva/current/eruptive_risk.asc 


