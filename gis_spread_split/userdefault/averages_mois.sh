g.region rast=orthophoto res=10000000000000
r.out.arc input=mois output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_live_average.txt dp=2
r.out.arc input=mois_l output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_1h_average.txt dp=2
r.out.arc input=mois_l0 output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_10h_average.txt dp=2
r.out.arc input=mois_l00 output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_100h_average.txt dp=2
r.out.arc input=mois_igor output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_live_igor_average.txt dp=2
r.out.arc input=mois_l_igor output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_1h_igor_average.txt dp=2
r.out.arc input=mois_l0_igor output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_10h_igor_average.txt dp=2
r.out.arc input=mois_l00_igor output=/var/www/gis_spread/split_spread/user_files/igor/averages/mois_100h_igor_average.txt dp=2