#!/bin/sh
	
g.mapset mapset=AdriaFireRisk

#Region ce biti w_dir1 jer je on najmanji


#Wind_dir
g.region  res=100;
g.remove rast=w_dir1,w_dir_extended,new_wind_extended,windAspect
r.in.arc input=/home/holistic/meteoArhiva//current/wind_dir.asc output=w_dir1 --overwrite
r.mapcalc w_dir_extended="-w_dir1+90" 
r.mapcalc new_wind_extended="if(w_dir_extended>=359.99, w_dir_extended-360, w_dir_extended)" 
g.region rast=w_dir1 res=100;
#r.mapcalc windAspect.255 = "if((cos((new_wind_extended-aspect@WebGis)/2))<0,255*abs((-cos((new_wind_extended-aspect@WebGis)/2))*kopno@WebGis),255*abs((cos((new_wind_extended-aspect@WebGis)/2)))*kopno@WebGis)" 
r.mapcalc windAspect.255 = "if((cos((new_wind_extended-aspect@WebGis)/2))<0,255*abs((-cos((new_wind_extended-aspect@WebGis)/2))),255*abs((cos((new_wind_extended-aspect@WebGis)/2))))" 
r.rescale input=windAspect.255 output=windAspect2 to=0,255 --overwrite
r.mapcalc windAspect="windAspect2"
r.null map=windAspect null=255
echo '0 green
128 yellow
255 red
end' | r.colors map=windAspect color=rules rules=-
g.region rast=w_dir1 res=500;
r.out.tiff -t input=windAspect output="/home/holistic/webapp/gis_data_holistic//windAspect.tif"
g.region rast=w_dir1 res=100;
g.remove rast=w_dir_extended,new_wind_extended,windAspect.255,windAspect2
g.remove rast=w_dir_extended,new_wind_extended,windAspect.255,windAspect2
g.remove rast=w_dir_extended,new_wind_extended,windAspect.255,windAspect2


#Wind_speed
g.remove rast=w_speed1
r.in.arc input=/home/holistic/meteoArhiva//current/wind_speed.asc output=w_speed1 --overwrite
#r.mapcalc windSlope.255="((w_speed1*10)+(slope@WebGis*10))*kopno@WebGis"
r.mapcalc windSlope.255="((w_speed1*10)+(slope@WebGis*10))"
r.mapcalc windSlope="if(windSlope.255>255,255,windSlope.255)"
r.null map=windSlope null=255
echo '0 green
128 yellow
255 red
end' | r.colors map=windSlope color=rules rules=-
g.region rast=w_dir1 res=500;
r.out.tiff -t input=windSlope output="/home/holistic/webapp/gis_data_holistic//windSlope.tif"
g.region rast=w_dir1 res=100;
g.remove rast=w_speed1,windSlope.255
g.remove rast=w_speed1,windSlope.255
g.remove rast=w_speed1,windSlope.255

#FWI
g.remove rast=fwi_1
#r.in.arc input=/home/holistic/meteoArhiva//current/FWI.asc output=fwi_1 --overwrite
g.copy rast=FWI@WebGis,fwi_1 --overwrite
#Normalizacija do 255
r.mapcalc fwi_1="fwi_1*9" 
r.null map=fwi_1 null=255
echo '0 50:150:235
4.5 100:185:0
10.5 255:190:55
18.5 255:130:35
29.5 235:60:45
end' | r.colors map=fwi_1 color=rules rules=-
g.region rast=w_dir1 res=500;
r.out.tiff -t input=fwi_1 output="/home/holistic/webapp/gis_data_holistic//fwi_1.tif"
g.region rast=w_dir1 res=100;


#Prec
g.remove rast=precTemp
r.in.arc input=/home/holistic/meteoArhiva//current/prec.asc output=precTemp --overwrite
r.null map=precTemp null=255
echo '0 0:161:230
1 0:209:140
5 0:220:0
10 161:230:51
15 230:220:51
20 230:176:46
25 240:130:41
30 240:0:0
100 255:0:0
end' | r.colors map=precTemp color=rules rules=-
g.region rast=w_dir1 res=500;
r.out.tiff -t input=precTemp output="/home/holistic/webapp/gis_data_holistic//prec.tif"
g.region rast=w_dir1 res=100;

#PrecModified
g.remove rast=precModified
r.in.arc input=/home/holistic/meteoArhiva//current/precModified.asc output=precModified --overwrite
r.null map=precModified null=255
#r.out.tiff -t input=precModified output="/home/holistic/webapp/gis_data_split//precModified.tif"
echo '0 green
128 yellow
255 red
end' | r.colors map=precModified color=rules rules=-
g.region rast=w_dir1 res=500;
r.out.tiff -t input=precModified output="/home/holistic/webapp/gis_data_holistic//precModified.tif"
g.region rast=w_dir1 res=100;


#MIRIP
g.remove vect=MIRIP_vector
#r.mapcalc MIRIP="(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*kopno@WebGis*precModified"
#r.mapcalc MIRIP="if(isnull(w_dir1),null(),if(MIRIP>255,255,MIRIP))"

##Mala promjena da gradovi budu 0 a ne prozirni
##r.mapcalc MIRIP="(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*kopno@WebGis*precModified"
#r.mapcalc MIRIP="(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*precModified"
#r.mapcalc MIRIP="if(isnull(MIRIP),0,MIRIP)"
##r.mapcalc MIRIP="if(isnull(w_dir1),null(),if(MIRIP>255,255,if(kopno@WebGis==0,null(),MIRIP)))"
#g.region rast=w_dir1 res=100;
##r.mapcalc MIRIP="if(isnull(w_dir1),null(),if(MIRIP>255,255,if(kopno@WebGis==0,null(),MIRIP)))"
#r.mapcalc MIRIP="if(isnull(w_dir1),0,if(MIRIP>255,255,if(kopno@WebGis==0,0,MIRIP)))"
#g.region rast=w_dir1 res=100;





r.mapcalc MIRIP= "(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*precModified"
r.mapcalc MIRIP="if(isnull(MIRIP),0,MIRIP)"
g.region rast=w_dir1 res=100;
#r.mapcalc MIRIP="if(isnull(w_dir1),0,if(MIRIP>255,255,if(voda@WebGis==1,0,MIRIP)))"
r.mapcalc MIRIP="if(voda@WebGis==1,0,MIRIP)"
r.mapcalc MIRIP="if(MIRIP>255,255,MIRIP)"
r.mapcalc MIRIP="if(isnull(w_dir1),0,MIRIP)"
g.region rast=w_dir1 res=100;


r.what input=fwi_1,elMIRIP,model,ObjektiMIRIP,windSlope,CesteMIRIP,windAspect,DalekovodiMIRIP,precModified,MIRIP east_north=1825741.945,5389473.435

echo '0 50:150:235
64 100:185:0
128 255:190:55
192 255:130:35
255 235:60:45
end' | r.colors map=MIRIP color=rules rules=-
r.out.tiff -t input=MIRIP output="/home/holistic/webapp/gis_data_holistic//MIRIP.tif"
echo 'AdriaFireRisk geotif exported'
#Priprema i export MIRIP vektora
g.region rast=w_dir1 res=500
r.reclass input=MIRIP output=MIRIPreclassed rules=/home/holistic/webapp/gis_spread_split/MIRIP/rules_MIRIP --overwrite
r.to.vect input=MIRIPreclassed output=MIRIP_vector feature=area --overwrite
#v.generalize input=MIRIP_preVector output=MIRIP_vector method=douglas threshold=20
v.out.ogr input=MIRIP_vector type=area dsn=/home/holistic/webapp/gis_data_holistic/ olayer=MIRIP_vector layer=1 format=ESRI_Shapefile --overwrite
g.region rast=w_dir1 res=100
g.remove rast=w_dir1
g.remove rast=windSlope
g.remove rast=windAspect
g.remove rast=fwi_1
g.remove rast=precModified
#g.remove rast=MIRIP
g.remove rast=windSlope
g.remove rast=windAspect
g.remove rast=fwi_1
g.remove rast=precModified
g.remove rast=MIRIPreclassed
g.remove vect=MIRIP_vector
g.remove vect=MIRIP_preVector

#wget -O - http://10.80.1.13/REST/importAdriaFireRiskData/5e4j8l22qlp9yy2n
python /home/holistic/webapp/gis_spread_split/MIRIP//pythonNotifyRisk.py



