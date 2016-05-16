#!/bin/sh

#Start1
g.remove rast=my_ros.max,my_ros.base,my_ros.maxdir,my_ros.spotdist,mois,mois_l,mois_l0,mois_l00,w_speed1,w_dir1
#End1

echo
echo "Calculate ROS:"

g.region rast=el res=100

#Start2
r.in.arc input=/var/www/gis_spread_split/files/wind_dir.asc output=w_dir1 type=FCELL mult=1.0
r.in.arc input=/var/www/gis_spread_split/files/wind_speed.asc output=w_speed1 type=FCELL mult=1.0
#End2

#Start3
#smjer vjetra popravljen
r.mapcalc w_dir1=w_dir1-180
#preracunaj u km/h
r.mapcalc w_speed1=w_speed1*54.68
#End3

#Start4
	r.in.arc input=/var/www/gis_spread_split/files/mois_live.asc output=mois type=FCELL mult=1.0
	r.in.arc input=/var/www/gis_spread_split/files/mois1h.asc output=mois_l type=FCELL mult=1.0
	r.in.arc input=/var/www/gis_spread_split/files/mois10h.asc output=mois_l0 type=FCELL mult=1.0
	r.in.arc input=/var/www/gis_spread_split/files/mois100h.asc output=mois_l00 type=FCELL mult=1.0
#End4

#Start5
r.ros -v model=model moisture_live=mois moisture_1h=mois_l moisture_10h=mois_l0 moisture_100h=mois_l00 velocity=w_speed1 direction=w_dir1 slope=slope aspect=aspect elevation=el output=my_ros
#End5