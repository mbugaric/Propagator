#1Start1
r.spread -v max=my_ros.max base=my_ros.base dir=my_ros.maxdir spot_dist=my_ros.spotdist w_speed=w_speed1 f_mois=mois_l start=start6880356 output=my_spread6880356 x_output=my_spread6880356.x y_output=my_spread6880356.y lag=120 comp_dens=0.2 
#1End1

#2Start2
cat /var/www/gis_spread/files/spread_color.log | r.colors map=my_spread color=rules
#2End2

echo "Spread done."
echo

#StartOutput
r.contour input=my_spread6914819 output=contour8067835 step=30 cut=0
r.out.tiff input=my_spread6914819 output="/var/www/gis_spread/user_files/KORISNIK/raster/spread_rast" compression=none -t 
v.out.ogr input=contour6880356 type=line,boundary dsn=/var/www/gis_spread/user_files/KORISNIK/vector/ olayer=spread_shape layer=1 format=ESRI_Shapefile
#EndOutput


#StartRealTime
#test
#EndRealTime

g.mremove -f rast="start*"
#g.mremove -f vect="contour*"
g.mremove -f vect="points*"
g.mremove -f rast="my_spre*"