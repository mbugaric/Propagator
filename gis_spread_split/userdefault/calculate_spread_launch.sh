
   g.mapset mapset=toni2
   history -w
   history -r ////.bash_history
   HISTFILE=////.bash_history
	
g.remove rast=my_ros.max,my_ros.base,my_ros.maxdir,my_ros.spotdist,w_speed1,mois_l

g.copy rast=el@WebGis,el
g.copy rast=my_ros.max@WebGis,my_ros.max
g.copy rast=my_ros.base@WebGis,my_ros.base
g.copy rast=my_ros.maxdir@WebGis,my_ros.maxdir
g.copy rast=my_ros.spotdist@WebGis,my_ros.spotdist
g.copy rast=w_speed1@WebGis,w_speed1
g.copy rast=mois_l@WebGis,mois_l

g.region n=4814229.12222 s=4786086.62766 e=6649340.71406 w=6621198.2195 res=75.3840073844
g.remove vect=points
v.in.ascii input='/var/www/gis_spread/user_files/toni2/ascii_toni2.txt' format='point' output='points4033462'  fs='|'
g.remove rast=my_spread,my_spread.x,my_spread.y,my_path,start4033462
v.to.rast input='points4033462' output='start4033462'  col=cat

#1Start1
r.spread -v max=my_ros.max base=my_ros.base dir=my_ros.maxdir spot_dist=my_ros.spotdist w_speed=w_speed1 f_mois=mois_l start=start4033462 output=my_spread4033462 x_output=my_spread4033462.x y_output=my_spread4033462.y lag=200 comp_dens=0.2 
#1End1

#2Start2
cat /var/www/gis_spread/files/spread_color.log | r.colors map=my_spread4033462 color=rules
#2End2

echo "Spread done."
echo

r.contour input=my_spread4033462 output=contour4033462 step=30 cut=0

echo
echo "Simulation done. Thanks for your interest!"

r.out.tiff input=my_spread4033462 output="/var/www/gis_spread/user_files/toni2/raster/spread_rast" compression=none -t 

v.out.ogr input=contour4033462 type=line,boundary dsn=/var/www/gis_spread/user_files/toni2/vector/ olayer=spread_shape layer=1 format=ESRI_Shapefile

g.remove rast=my_spread4033462,my_spread4033462.x,my_spread4033462.y,start4033462
g.remove vect=points4033462,contour4033462
#End2