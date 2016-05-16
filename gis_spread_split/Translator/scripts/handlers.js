EventHelper.addEventHandler(window, 'load', initialize);

function initialize()
{
	//GET VARIABLES FROM HTTP REQUEST OR SET DEFAULT
	var defaultPageNumber = 1;
	var defaultPageSize = 10;
	var defaultSourceLanguage = 'ENG';
	var defaultDestinationLanguage = 'HRV';
	
	var pageNumber = UrlHelper.getAttributeValue('pageNumber') || defaultPageNumber; 	// use page number, if pageNumber is not set use 1
	var pageSize =  UrlHelper.getAttributeValue('pageSize') || defaultPageSize;
	var sourceLanguage = UrlHelper.getAttributeValue('sourceLanguage') || defaultSourceLanguage;
	var destinationLanguage = UrlHelper.getAttributeValue('destinationLanguage') || defaultDestinationLanguage;
	
	//GET NECESSARY DOM ELEMENTS
	var pageSizeSelector = document.getElementById('pageSize');
	var sourceLanguageSelector = document.getElementById('sourceLanguage');
	var destinationLanguageSelector = document.getElementById('destinationLanguage');
	var buttonSave = document.getElementById('buttonSave');
		
	//SELECT APPROPRIATE OPTIONS
	DomHelper.selectOption(pageSizeSelector, pageSize);
	DomHelper.selectOption(sourceLanguageSelector, sourceLanguage);
	DomHelper.selectOption(destinationLanguageSelector, destinationLanguage);
	
	//Add events
	EventHelper.addEventHandler(pageSizeSelector, 'change', ajaxHandleConditionsChanged);
	EventHelper.addEventHandler(sourceLanguageSelector, 'change', ajaxHandleConditionsChanged);
	EventHelper.addEventHandler(destinationLanguageSelector, 'change', ajaxHandleConditionsChanged);
}

function ajaxHandleConditionsChanged()
{
	var pageSizeChoice = document.getElementById('pageSize').value;
	var pageNumber = document.getElementById('pageNumber').value;
	var sourceLanguageChoice = document.getElementById('sourceLanguage').value;
	var destinationLanguageChoice = document.getElementById('destinationLanguage').value;
	var uiLanguage = document.getElementById('uiLanguage').value;
	
	updateStatusLabel("Updating items...");
	
	if(pageSizeChoice && sourceLanguageChoice && destinationLanguageChoice && pageNumber)
	{
		var url = "showTranslator.php"
				+ "?sourceLanguage=" + sourceLanguageChoice
				+ "&destinationLanguage=" + destinationLanguageChoice
				+ "&pageNumber=" + pageNumber 
				+ "&pageSize=" + pageSizeChoice
				+ "&uiLanguage="+ uiLanguage;
		
		Ajax.get(url, handleTranslationItemsArrived);
	}
}

function handleTranslationItemsArrived(response)
{
	 var translationCollectionContainer = document.getElementById("translationCollectionContainer");
	 
	 if(translationCollectionContainer)
	 {
		 translationCollectionContainer.innerHTML = response;
	 }
	 
	 updateStatusLabel("Items updated");
	 Timer.intervalElapsed(2, 'updateStatusLabel("")');
}

function ajaxHandleSaveClick() // added in the TranslationCollectionTemplate.html
{	
	updateStatusLabel("Saving items");
	
	var destinationLanguageTextAreas = DomHelper.getElementsIdStartsWith("textarea","TranslationSecondValue");
	var indexHolderElements = DomHelper.getElementsIdStartsWith("input","Index");
	var keyHolderElements = DomHelper.getElementsIdStartsWith("input","Key");
	var destinationLanguageItem = document.getElementById("destinationLanguage");
	
	var dataAsString = "";
	
	if(destinationLanguageItem)
	{
		dataAsString += "destinationLanguage=" + destinationLanguageItem.value + "&";
	}
	
	dataAsString += "ItemsToSave=";
	
	if(destinationLanguageTextAreas.length !== indexHolderElements.length){return false;}
	
	for(var i = 0; i < indexHolderElements.length; i++)
	{
		dataAsString += destinationLanguageTextAreas[i].value.replace("\n"," ") 
					 + "__" + indexHolderElements[i].value
					 + "__" + keyHolderElements[i].value 
					 + ";;";
	}
	
	Ajax.post("TranslatorSaver.php", dataAsString, handleSaveFinished);
		
	return false; //necessary so that button click doesn't cause submit
}

function handleSaveFinished(response)
{
	updateStatusLabel("Items saved");
	if(response!="")
	{
		alert(response);
	}
	Timer.intervalElapsed(2, 'updateStatusLabel("")');
}

function updateStatusLabel(textToDisplay)
{
	var statusLabel = document.getElementById('statusLabel');
	
	if(statusLabel)
	{
		statusLabel.innerHTML = textToDisplay;
	}
}