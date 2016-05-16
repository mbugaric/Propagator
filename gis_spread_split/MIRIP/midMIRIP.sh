#!/bin/sh
	
g.mapset mapset=AdriaFireRisk

g.region rast=FWI@WebGis res=100;


#Ceste
g.remove rast=Ceste,Ceste.buf,CesteMIRIP
g.remove vect=Ceste
v.in.ogr dsn=/home/holistic/webapp/gis_data_holistic//road.shp output=Ceste --overwrite
v.to.rast input=Ceste output=Ceste column=jurisdicti
r.buffer input=Ceste output=Ceste.buf distances=7.84,15.68,23.52,31.36,39.2,47.04,54.88,62.72,70.56,78.4,86.24,94.08,101.92,109.76,117.6,125.44,133.28,141.12,148.96,156.8,164.64,172.48,180.32,188.16,196,203.84,211.68,219.52,227.36,235.2,243.04,250.88,258.72,266.56,274.4,282.24,290.08,297.92,305.76,313.6,321.44,329.28,337.12,344.96,352.8,360.64,368.48,376.32,384.16,392,399.84,407.68,415.52,423.36,431.2,439.04,446.88,454.72,462.56,470.4,478.24,486.08,493.92,501.76,509.6,517.44,525.28,533.12,540.96,548.8,556.64,564.48,572.32,580.16,588,595.84,603.68,611.52,619.36,627.2,635.04,642.88,650.72,658.56,666.4,674.24,682.08,689.92,697.76,705.6,713.44,721.28,729.12,736.96,744.8,752.64,760.48,768.32,776.16,784,791.84,799.68,807.52,815.36,823.2,831.04,838.88,846.72,854.56,862.4,870.24,878.08,885.92,893.76,901.6,909.44,917.28,925.12,932.96,940.8,948.64,956.48,964.32,972.16,980,987.84,995.68,1003.52,1011.36,1019.2,1027.04,1034.88,1042.72,1050.56,1058.4,1066.24,1074.08,1081.92,1089.76,1097.6,1105.44,1113.28,1121.12,1128.96,1136.8,1144.64,1152.48,1160.32,1168.16,1176,1183.84,1191.68,1199.52,1207.36,1215.2,1223.04,1230.88,1238.72,1246.56,1254.4,1262.24,1270.08,1277.92,1285.76,1293.6,1301.44,1309.28,1317.12,1324.96,1332.8,1340.64,1348.48,1356.32,1364.16,1372,1379.84,1387.68,1395.52,1403.36,1411.2,1419.04,1426.88,1434.72,1442.56,1450.4,1458.24,1466.08,1473.92,1481.76,1489.6,1497.44,1505.28,1513.12,1520.96,1528.8,1536.64,1544.48,1552.32,1560.16,1568,1575.84,1583.68,1591.52,1599.36,1607.2,1615.04,1622.88,1630.72,1638.56,1646.4,1654.24,1662.08,1669.92,1677.76,1685.6,1693.44,1701.28,1709.12,1716.96,1724.8,1732.64,1740.48,1748.32,1756.16,1764,1771.84,1779.68,1787.52,1795.36,1803.2,1811.04,1818.88,1826.72,1834.56,1842.4,1850.24,1858.08,1865.92,1873.76,1881.6,1889.44,1897.28,1905.12,1912.96,1920.8,1928.64,1936.48,1944.32,1952.16,1960,1967.84,1975.68,1983.52,1991.36,1999.2,
r.null map=Ceste.buf null=255   
#r.mapcalc "CesteMIRIP = abs(Ceste.buf-255)*kopno@WebGis " 
r.mapcalc "CesteMIRIP = abs(Ceste.buf-255) " 
echo '0 green
128 yellow
255 red
end' | r.colors map=CesteMIRIP color=rules rules=-
g.region rast=FWI@WebGis res=500;
r.out.tiff -t input=CesteMIRIP output="/home/holistic/webapp/gis_data_holistic//CesteMIRIP.tif"
g.region rast=FWI@WebGis res=100;
g.remove rast=Ceste,Ceste.buf
g.remove vect=Ceste
g.remove rast=Ceste,Ceste.buf
g.remove vect=Ceste

#Objekti
g.remove rast=Objekti,Objekti.buf,ObjektiMIRIP
g.remove vect=Objekti
v.in.ogr dsn=/home/holistic/webapp/gis_data_holistic//building.shp output=Objekti --overwrite
v.to.rast input=Objekti output=Objekti column=jurisdicti
r.buffer input=Objekti output=Objekti.buf distances=58.82,117.64,176.46,235.28,294.1,352.92,411.74,470.56,529.38,588.2,647.02,705.84,764.66,823.48,882.3,941.12,999.94,1058.76,1117.58,1176.4,1235.22,1294.04,1352.86,1411.68,1470.5,1529.32,1588.14,1646.96,1705.78,1764.6,1823.42,1882.24,1941.06,1999.88,2058.7,2117.52,2176.34,2235.16,2293.98,2352.8,2411.62,2470.44,2529.26,2588.08,2646.9,2705.72,2764.54,2823.36,2882.18,2941,2999.82,3058.64,3117.46,3176.28,3235.1,3293.92,3352.74,3411.56,3470.38,3529.2,3588.02,3646.84,3705.66,3764.48,3823.3,3882.12,3940.94,3999.76,4058.58,4117.4,4176.22,4235.04,4293.86,4352.68,4411.5,4470.32,4529.14,4587.96,4646.78,4705.6,4764.42,4823.24,4882.06,4940.88,4999.7,5058.52,5117.34,5176.16,5234.98,5293.8,5352.62,5411.44,5470.26,5529.08,5587.9,5646.72,5705.54,5764.36,5823.18,5882,5940.82,5999.64,6058.46,6117.28,6176.1,6234.92,6293.74,6352.56,6411.38,6470.2,6529.02,6587.84,6646.66,6705.48,6764.3,6823.12,6881.94,6940.76,6999.58,7058.4,7117.22,7176.04,7234.86,7293.68,7352.5,7411.32,7470.14,7528.96,7587.78,7646.6,7705.42,7764.24,7823.06,7881.88,7940.7,7999.52,8058.34,8117.16,8175.98,8234.8,8293.62,8352.44,8411.26,8470.08,8528.9,8587.72,8646.54,8705.36,8764.18,8823,8881.82,8940.64,8999.46,9058.28,9117.1,9175.92,9234.74,9293.56,9352.38,9411.2,9470.02,9528.84,9587.66,9646.48,9705.3,9764.12,9822.94,9881.76,9940.58,9999.4,10058.22,10117.04,10175.86,10234.68,10293.5,10352.32,10411.14,10469.96,10528.78,10587.6,10646.42,10705.24,10764.06,10822.88,10881.7,10940.52,10999.34,11058.16,11116.98,11175.8,11234.62,11293.44,11352.26,11411.08,11469.9,11528.72,11587.54,11646.36,11705.18,11764,11822.82,11881.64,11940.46,11999.28,12058.1,12116.92,12175.74,12234.56,12293.38,12352.2,12411.02,12469.84,12528.66,12587.48,12646.3,12705.12,12763.94,12822.76,12881.58,12940.4,12999.22,13058.04,13116.86,13175.68,13234.5,13293.32,13352.14,13410.96,13469.78,13528.6,13587.42,13646.24,13705.06,13763.88,13822.7,13881.52,13940.34,13999.16,14057.98,14116.8,14175.62,14234.44,14293.26,14352.08,14410.9,14469.72,14528.54,14587.36,14646.18,14705,14763.82,14822.64,14881.46,14940.28,14999.1,
r.null map=Objekti.buf null=255   
#r.mapcalc "ObjektiMIRIP = abs(Objekti.buf-255)*kopno@WebGis " 
r.mapcalc "ObjektiMIRIP = abs(Objekti.buf-255) " 
echo '0 green
128 yellow
255 red
end' | r.colors map=ObjektiMIRIP color=rules rules=-
g.region rast=FWI@WebGis res=500;
r.out.tiff -t input=ObjektiMIRIP output="/home/holistic/webapp/gis_data_holistic//ObjektiMIRIP.tif"
g.region rast=FWI@WebGis res=100;
g.remove rast=Objekti,Objekti.buf
g.remove vect=Objekti
g.remove rast=Objekti,Objekti.buf
g.remove vect=Objekti

#Dalekovodi
g.remove rast=Dalekovodi,Dalekovodi.buf,DalekovodiMIRIP
g.remove vect=Dalekovodi
v.in.ogr dsn=/home/holistic/webapp/gis_data_holistic//transmission_line.shp output=Dalekovodi --overwrite
v.to.rast input=Dalekovodi output=Dalekovodi column=jurisdicti
r.buffer input=Dalekovodi output=Dalekovodi.buf distances=78.43,156.86,235.29,313.72,392.15,470.58,549.01,627.44,705.87,784.3,862.73,941.16,1019.59,1098.02,1176.45,1254.88,1333.31,1411.74,1490.17,1568.6,1647.03,1725.46,1803.89,1882.32,1960.75,2039.18,2117.61,2196.04,2274.47,2352.9,2431.33,2509.76,2588.19,2666.62,2745.05,2823.48,2901.91,2980.34,3058.77,3137.2,3215.63,3294.06,3372.49,3450.92,3529.35,3607.78,3686.21,3764.64,3843.07,3921.5,3999.93,4078.36,4156.79,4235.22,4313.65,4392.08,4470.51,4548.94,4627.37,4705.8,4784.23,4862.66,4941.09,5019.52,5097.95,5176.38,5254.81,5333.24,5411.67,5490.1,5568.53,5646.96,5725.39,5803.82,5882.25,5960.68,6039.11,6117.54,6195.97,6274.4,6352.83,6431.26,6509.69,6588.12,6666.55,6744.98,6823.41,6901.84,6980.27,7058.7,7137.13,7215.56,7293.99,7372.42,7450.85,7529.28,7607.71,7686.14,7764.57,7843,7921.43,7999.86,8078.29,8156.72,8235.15,8313.58,8392.01,8470.44,8548.87,8627.3,8705.73,8784.16,8862.59,8941.02,9019.45,9097.88,9176.31,9254.74,9333.17,9411.6,9490.03,9568.46,9646.89,9725.32,9803.75,9882.18,9960.61,10039.04,10117.47,10195.9,10274.33,10352.76,10431.19,10509.62,10588.05,10666.48,10744.91,10823.34,10901.77,10980.2,11058.63,11137.06,11215.49,11293.92,11372.35,11450.78,11529.21,11607.64,11686.07,11764.5,11842.93,11921.36,11999.79,12078.22,12156.65,12235.08,12313.51,12391.94,12470.37,12548.8,12627.23,12705.66,12784.09,12862.52,12940.95,13019.38,13097.81,13176.24,13254.67,13333.1,13411.53,13489.96,13568.39,13646.82,13725.25,13803.68,13882.11,13960.54,14038.97,14117.4,14195.83,14274.26,14352.69,14431.12,14509.55,14587.98,14666.41,14744.84,14823.27,14901.7,14980.13,15058.56,15136.99,15215.42,15293.85,15372.28,15450.71,15529.14,15607.57,15686,15764.43,15842.86,15921.29,15999.72,16078.15,16156.58,16235.01,16313.44,16391.87,16470.3,16548.73,16627.16,16705.59,16784.02,16862.45,16940.88,17019.31,17097.74,17176.17,17254.6,17333.03,17411.46,17489.89,17568.32,17646.75,17725.18,17803.61,17882.04,17960.47,18038.9,18117.33,18195.76,18274.19,18352.62,18431.05,18509.48,18587.91,18666.34,18744.77,18823.2,18901.63,18980.06,19058.49,19136.92,19215.35,19293.78,19372.21,19450.64,19529.07,19607.5,19685.93,19764.36,19842.79,19921.22,19999.65,
r.null map=Dalekovodi.buf null=255   
#r.mapcalc "DalekovodiMIRIP = abs(Dalekovodi.buf-255)*kopno@WebGis " 
r.mapcalc "DalekovodiMIRIP = abs(Dalekovodi.buf-255) " 
echo '0 green
128 yellow
255 red
end' | r.colors map=DalekovodiMIRIP color=rules rules=-
g.region rast=FWI@WebGis res=500;
r.out.tiff -t input=DalekovodiMIRIP output="/home/holistic/webapp/gis_data_holistic//DalekovodiMIRIP.tif"
g.region rast=FWI@WebGis res=100;
g.remove rast=Dalekovodi,Dalekovodi.buf
g.remove vect=Dalekovodi
g.remove rast=Dalekovodi,Dalekovodi.buf
g.remove vect=Dalekovodi


