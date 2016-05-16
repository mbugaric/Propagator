g.remove rast='mois_admin'
g.remove rast='mois_l_admin'
g.remove rast='mois_l0_admin'
g.remove rast='mois_l00_admin'

r.mapcalc mois_admin=3*kopno
r.mapcalc mois_l_admin=3*kopno
r.mapcalc mois_l0_admin=3*kopno
r.mapcalc mois_l00_admin=3*kopno

g.region rast=kopno res=500

r.out.arc input=mois_admin output=/var/www/gis_spread/split_spread/user_files/admin/mois_live.asc dp=1
r.out.arc input=mois_l_admin output=/var/www/gis_spread/split_spread/user_files/admin/mois1h.asc dp=1
r.out.arc input=mois_l0_admin output=/var/www/gis_spread/split_spread/user_files/admin/mois10h.asc dp=1
r.out.arc input=mois_l00_admin output=/var/www/gis_spread/split_spread/user_files/admin/mois100h.asc dp=1