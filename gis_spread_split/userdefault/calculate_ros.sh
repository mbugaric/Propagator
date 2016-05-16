#!/bin/sh

#Start1
g.remove rast=my_ros.max,my_ros.base,my_ros.maxdir,my_ros.spotdist,mois,mois_l
#End1

echo
echo "Calculate ROS:"



#Start2
r.in.arc input=/var/www/gis_spread/split_spread/files/wind_dir.asc output=w_dir1 type=FCELL mult=1.0
r.in.arc input=/var/www/gis_spread/split_spread/files/wind_speed.asc output=w_speed1 type=FCELL mult=1.0
#End2

#Start3
#smjer vjetra popravljen
r.mapcalc w_dir1=w_dir1-180
#preracunaj u km/h
r.mapcalc w_speed1=w_speed1*54.68
#End3

#Start4
r.mapcalc mois=3*kopno
r.mapcalc mois_l=3*kopno
r.mapcalc mois_l0=3*kopno
r.mapcalc mois_l00=3*kopno
echo
echo "Calculate the ROS (rate of spread), etc.:"
#End4

#Start5
r.ros -v model=model moisture_live=mois moisture_1h=mois_l moisture_10h=mois_l0 moisture_100h=mois_l00 velocity=w_speed1 direction=w_dir1 slope=slope aspect=aspect elevation=el output=my_ros
r.out.tiff input=my_ros.base output=ros_base compression=none -t 
#End5