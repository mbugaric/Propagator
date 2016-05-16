#!/bin/sh
	
#treba pripremit kopno pažljivo
#kopno pune rezolucije nije dobro ako je res=500+
#zbog toga se kreira kopno2 sa grow
#ovdje ispod je primjer kako se to radi
#i kopno i kopno2 bi trebali biti u default mapsetu

#g.region rast=kopno
#g.copy rast=kopno_bck_old,kopno --overwrite
#g.region rast=kopno res=400
#g.remove rast=kopno2,kopno.buf,kopno.grown
#r.mapcalc "kopno2=if(kopno==0,null(),kopno)"
#r.grow in=kopno2 out=kopno.grown radius=2 --overwrite
#g.remove rast=kopno2,kopno.buf
#g.copy rast=kopno.grown,kopno2 --overwrite
#g.region rast=w_dir
#r.mapcalc "kopno2=if(isnull(kopno2),0,kopno2)"


g.mapset mapset=WebGis
	
#Vodene povrsine
g.remove rast=voda
g.remove vect=voda
v.in.ogr dsn=/home/holistic/webapp/gis_data_holistic//voda.shp output=voda --overwrite
v.to.rast input=voda output=voda col='BORDER_WID'
echo '0 green
1 red
end' | r.colors map=voda color=rules rules=-
r.null map=voda@WebGis null=0
g.region rast=voda@WebGis res=500;
r.out.tiff -t input=voda output="/home/holistic/webapp/gis_data_holistic/voda.tif"
g.region rast=voda@WebGis res=100;
g.remove vect=voda

	
g.mapset mapset=AdriaFireRisk
	
#Corine
g.remove rast=model
g.remove rast=model_temp
g.remove rast=Corine_raster
g.remove vect=Corine
#v.in.ogr dsn=/home/holistic/webapp/gis_data_holistic/clc_sve.shp output=Corine --overwrite
g.copy vect=Corine_modelAlbini@WebGis,Corine --overwrite
g.region vect=Corine res=20
v.to.rast --verbose input=Corine output=Corine_raster use=attr column=kod
r.reclass input=Corine_raster output=model_temp rules=/home/holistic/webapp/gis_spread_split/MIRIP/rules_corine
#Stavit gradove bar u 5
r.mapcalc "model = if(isnull(model_temp), 5, model_temp)"
g.remove rast=Corine_raster
g.remove vect=Corine
g.remove rast=model_temp
g.remove rast=Corine_raster
g.remove vect=Corine
g.remove rast=model_temp


#Elevacija, aspect, slope, kopno, elMIRIP, elMIRIP.max
g.region rast=el@WebGis
g.remove rast=elMIRIP
g.remove rast=elMIRIP.max
g.region rast=el@WebGis
r.mapcalc "elMIRIP.max = if(el@WebGis>1000,1000,el@WebGis)"
r.mapcalc "elMIRIP.max = if(elMIRIP.max<0,0,elMIRIP.max)"
r.rescale input=elMIRIP.max output=elMIRIP to=0,255 --overwrite
#r.mapcalc "elMIRIP = abs(elMIRIP-255)*kopno@WebGis"
r.mapcalc "elMIRIP = abs(elMIRIP-255)"
g.remove rast=elMIRIP.max

