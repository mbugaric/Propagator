g.remove -f vect=modelScottVector 
g.remove -f vect=Corine

g.copy vect=Corine@WebGis,Corine
cat /home/holistic/webapp/gis_spread_split/user_files/admin/reclass_Scott.r | v.reclass --overwrite input=Corine output=modelScottVector column=Code_06 type=centroid

v.out.ogr input=modelScottVector type=area dsn=/home/holistic/webapp/gis_spread_split/user_files/admin/vector/ olayer=modelScottVector layer=1 format=ESRI_Shapefile --overwrite
