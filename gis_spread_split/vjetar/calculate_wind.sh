g.region rast=el res=750
g.remove rast='wind_dir_temp_admin'
r.in.arc input=/var/www/gis_spread/user_files/admin/wind_dir.asc output=wind_dir_temp_admin type=FCELL mult=1.0
r.out.arc input=wind_dir_temp_admin output=/var/www/gis_spread/user_files/admin/wind_dir_temp_1.asc dp=1
g.remove rast='wind_speed_temp_admin'
r.in.arc input=/var/www/gis_spread/user_files/admin/wind_speed.asc output=wind_speed_temp_admin type=FCELL mult=1.0
r.out.arc input=wind_speed_temp_admin output=/var/www/gis_spread/user_files/admin/wind_speed_temp_1.asc dp=2