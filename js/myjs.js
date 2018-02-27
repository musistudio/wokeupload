/**
 *自己把常用的方法封装成一个小框架 
 */
//增加replaceAll方法
String.prototype.replaceAll = function(s1,s2){
	return this.replace(new RegExp(s1,"gm"),s2); 
}

//ajax中处理data的方法
function dealData (obj) {
	var str = JSON.stringify(obj);
	str = str.replaceAll("{","");
	str = str.replaceAll("}","");
	str = str.replaceAll('"','');
	str = str.replaceAll(":","=");
	var dataArr = str.split(",");
	var res = "";
	var len = dataArr.length;
	for (var i =0;i<len;i++) {
		res += dataArr[i];
		if (i != len-1) {
			res += "&";
		}
	}
	return res;
}

//ajax中处理header的方法
function dealHeader(xmlObj, obj){
	var str = JSON.stringify(obj);
	str = str.replaceAll("{","");
	str = str.replaceAll("}","");
	str = str.replaceAll('"','');
	str = str.replaceAll('_','-');
	var headerArr = str.split(",");
	for (var i =0;i<headerArr.length;i++) {
			var s = headerArr[i];
			var len = headerArr.length;
			var a = str.indexOf(":");
			xmlObj.setRequestHeader(s.substring(0,a),s.substring(a+1));
		}
}

//封装自定义方法
function _(arg) {
	var type = typeof arg;
	switch(type) {
		case "string":
			if(arg.substr(0, 1) == ".") {
				return document.getElementById(arg.replace(".",""));
			} else if(arg.substr(0, 1) == "#") {
				return document.getElementsByClassName(arg.replace("#",""));
			}

		case "function":
			arg();
		default:
			break;
	}
}


//封装ajax方法
function _ajax (object) {
	if (typeof object == "object") {
		var xmlhttp;
		if(window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open(object.method, object.url, true);
		if(object.header) {
			dealHeader(xmlhttp, object.header);
		}
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
		if(object.method == "post") {
			if(object.data) {
				xmlhttp.send(dealData(object.data));
			}
		} else {
			xmlhttp.send();
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
					switch (object.type){
						case "json":
                            object.success(eval('(' + xmlhttp.responseText + ')'));
							break;
						case "text":
							object.success(xmlhttp.responseText);
							break;
						case "xml":
							object.success(xmlhttp.responseXML);
							break;
						default:
							object.success(xmlhttp.responseText);
							break;
					}
				} else{
					if(object.error){
                        object.error();
					}

				}	
			}
		}
	}
}