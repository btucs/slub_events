'use strict';
import DocumentService from"@typo3/core/document-service.js";
import DateTimePicker from"@typo3/backend/date-time-picker.js";

DocumentService.ready().then((()=>{
	document.querySelectorAll('.t3js-datetimepicker').forEach((element=>{
		DateTimePicker.initialize(element);
	}));
}));
