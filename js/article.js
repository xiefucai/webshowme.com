(function(d){
	var getElem = function(a){
		return d.getElementById(a);
	};
	getElem('backBtn').onClick = function(event){
		var domain = /:\/\/([\w\-\.\:]+)/.exec(document.referrer)
		if ((domain && domain[1]) === location.hostname){
			history.go(-1);
			return false;
		}else{
			return true;
		}
	}
})(document);