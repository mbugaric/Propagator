import urllib2

response = urllib2.urlopen('http://10.80.1.13/REST/importAdriaFireRiskData/5e4j8l22qlp9yy2n')
headers = response.info()
data = response.read()
print data


