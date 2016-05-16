g.remove vect=points
v.in.ascii input='/var/www/gis_spread/files/ascii.txt' format='point' output='points'  fs='|'
g.remove rast=my_spread,my_spread.x,my_spread.y,my_path,start1
v.to.rast input='points' output='start1'  col=cat
