(function(d){
	var g = function(name){
			return d.getElementById(name);
		},
		gs = function(xml,name,i){
			var elms = xml.getElementsByTagName(name);
			if (i!==undefined){
				return elms[i];
			}
			return elms;
		},
		css = {
			"bg":"position:fixed;background:rgba(0,0,0,.5);left:0;z-index:9999999999999999;top:0;overflow:hidden;width:100%;height:100%;",
			"fucaixie":"width:1010px;margin:10px auto 0;background:#fff;border:1px solid #ccc;top:5px;border-radius:5px 5px 0 0;",
			"fucaixie-close":"font-size:24px;color:#999;font-weight:bold;text-decoration:none;position:absolute;left:50%;margin-left:470px;top:10px;display:block;padding:10px 0;line-height:1;",
			"fucaixie-tit":"border-bottom:1px solid #ccc;padding:10px 10px;margin:0 5px;font-size:14px;color:#333;",
			"fucaixie-win":"padding:0;margin:0 0 5px;overflow:hidden;overflow:hidden;",
			"label":"line-height:30px;text-align:center;position:absolute;bottom:0;left:0;width:246px;display:block;background:rgba(0,0,0,.3);color:#fff;",
			"a":"padding:2px;border:1px solid #ccc;display:block;",
			"ul":"float:left;margin:5px 0 0 5px;padding:0;list-Style:none;",
			"li":"margin:0 0 5px 0;line-height:1;position:relative;",
			"img":"vertical-align:bottom;width:240px;"
		},
		dom = (function(d){
				if (g("fucaixie")){
					return g("fucaixie");
				}else{
					var bg = d.createElement("div");
						d.body.appendChild(bg);
						bg.setAttribute("style",css["bg"]);
					var close = d.createElement("a");
						close.id = "fucaixie-close";
						bg.appendChild(close);
						close.setAttribute("style",css["fucaixie-close"]);
						close.innerHTML = "&times;";
						close.href="javascript:;";
						close.onclick = function(){
							this.parentNode.style.display="none";
						};
					var elm = d.createElement("div");
						elm.id = "fucaixie";
						bg.appendChild(elm);
						elm.setAttribute("style",css["fucaixie"]);
					var title = d.createElement("h2");
						title.id = "fucaixie-tit";
						elm.appendChild(title);
						title.setAttribute("style",css["fucaixie-tit"]);
						title.innerHTML = "下载图片";
					var win = d.createElement("div");
						win.id = "fucaixie-win";
						elm.appendChild(win);
						win.setAttribute("style",css["fucaixie-win"]);
						win.style.height = (document.documentElement.clientHeight-60)+"px";
						bg.onmousewheel = function(event){
							k = event.wheelDelta? event.wheelDelta:-event.detail*10;
							win.scrollTop = win.scrollTop - k;
							return false;
						};
					window.showPlugin = function(){
						bg.style.display = "block";
					}
					return {"win":elm,"tit":title,"win":win};
				}
			})(d),
		showImages = function(imgarr){
			var getFileName = function(filename){
				var name = /\/([^\/]+)$/.exec(filename.replace(/[#\?].*$/,""));
				return name && name[1];
			},
			_temp = [
				[],[],[],[]
			],
			_h = [0,0,0,0],
			index = 0,
			arr =[]
			
			;
			imgarr.sort(function(v1,v2){
				return v2.width-v1.width;
			});
			
			for(var i=0,k=imgarr.length;i<k;i++){
				_temp[index].push('<li style="'+css["li"]+'"><a href="'+imgarr[i].src+'" download="'+getFileName(imgarr[i].src)+'" style="'+css["a"]+'"><img src="'+imgarr[i].src+'"  style="'+css["img"]+'"/></a><label style="'+css["label"]+'">'+[imgarr[i].width,imgarr[i].height].join('&times;')+'</label></li>');
				_h[index] += imgarr[i].height;
				index = _h.indexOf(Math.min(_h[0],_h[1],_h[2],_h[3]));
			}
			index = _h.indexOf(Math.max(_h[0],_h[1],_h[2],_h[3]));
			arr.push('<ul style="'+css["ul"]+'">'+_temp[index].join("\n")+'</ul>');
			_h[index] = 0;
			index = _h.indexOf(Math.max(_h[0],_h[1],_h[2],_h[3]));
			arr.push('<ul style="'+css["ul"]+'">'+_temp[index].join("\n")+'</ul>');
			_h[index] = 0;
			index = _h.indexOf(Math.max(_h[0],_h[1],_h[2],_h[3]));
			arr.push('<ul style="'+css["ul"]+'">'+_temp[index].join("\n")+'</ul>');
			_h[index] = 0;
			index = _h.indexOf(Math.max(_h[0],_h[1],_h[2],_h[3]));
			arr.push('<ul style="'+css["ul"]+'">'+_temp[index].join("\n")+'</ul>');
			_h[index] = 0;
			dom.win.innerHTML = arr.join("\n");
		},
		imgarr = (function(d){
			var imgs = d.images,arr = [];
				for (var i=0,k=imgs.length;i<k;i++){
					var img = new Image();
						img.index = i;
						img.onload = function(){
							var w = this.width,h = this.height,src = this.src;
							if (w>=90 && h>=90){
								if (Math.max(w/h,h/w)<6){
									arr.push({"src":src,"width":w,"height":h});
								}else if (Math.min(w,h)>=280){
									arr.push({"src":src,"width":w,"height":h});
								}else{
									delete(imgs[this.index]);
								}
							}else{
								delete(imgs[this.index]);
							}
							
							if (imgs.length = arr.length){
								showImages(arr);
							}
						}
						img.onerror = function(){
							delete(imgs[this.index]);
							if (imgs.length = arr.length){
								showImages(arr);
							}
						}
						img.src = imgs[i].src;
				}
		})(d);
})(document);