g.region rast=el res=750
g.remove rast='wind_dir_temp_KORISNIK'
r.in.arc input=/var/www/gis_spread/split_spread/files/wind_dir.asc output=wind_dir_temp_KORISNIK type=FCELL mult=1.0
r.out.arc input=wind_dir_temp_KORISNIK output=/var/www/gis_spread/split_spread/user_files/KORISNIK/wind_dir_temp_0.asc dp=1
g.remove rast='wind_speed_temp_KORISNIK'
r.in.arc input=/var/www/gis_spread/split_spread/files/wind_speed.asc output=wind_speed_temp_KORISNIK type=FCELL mult=1.0
r.out.arc input=wind_speed_temp_KORISNIK output=/var/www/gis_spread/split_spread/user_files/KORISNIK/wind_speed_temp_0.asc dp=2