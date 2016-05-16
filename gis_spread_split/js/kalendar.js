// kalendar
var DayOfWeek = new Array('nedjelja','ponedjeljak','utorak','srijeda','četvrtak','petak','subota');
       var MonthName = new Array('I','II','III','IV','V','VI','VII','VIII','IX',
                          'X','XI','XII');
       var theDate = new Date();

       document.write('<NOBR>' +
               DayOfWeek[theDate.getDay()] + ' ' +
               theDate.getDate() + '. ' +
			   MonthName[theDate.getMonth()] + ' ' +
               (theDate.getYear() < 1000 ? theDate.getYear() + 1900 : theDate.getYear()) +
              '.</NOBR>');