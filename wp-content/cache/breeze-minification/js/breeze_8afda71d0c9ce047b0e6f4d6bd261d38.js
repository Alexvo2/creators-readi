
!function(){var e,t;window.flexibility={},Array.prototype.forEach||(Array.prototype.forEach=function(e){if(null==this)throw new TypeError(this+"is not an object");if(!(e instanceof Function))throw new TypeError(e+" is not a function");for(var t=Object(this),n=arguments[1],i=t instanceof String?t.split(""):t,r=Math.max(Math.min(i.length,9007199254740991),0)||0,l=-1;++l<r;)l in i&&e.call(n,i[l],l,t)}),e=flexibility,t=function(){var t=function(){function Ie(e){return void 0===e}function qe(e){return e===lt||e===ot}function Me(e,t){if(void 0!==e.style.marginStart&&qe(t))return e.style.marginStart;var n=null;switch(t){case"row":n=e.style.marginLeft;break;case"row-reverse":n=e.style.marginRight;break;case"column":n=e.style.marginTop;break;case"column-reverse":n=e.style.marginBottom}return void 0!==n?n:void 0!==e.style.margin?e.style.margin:0}function $e(e,t){if(void 0!==e.style.marginEnd&&qe(t))return e.style.marginEnd;var n=null;switch(t){case"row":n=e.style.marginRight;break;case"row-reverse":n=e.style.marginLeft;break;case"column":n=e.style.marginBottom;break;case"column-reverse":n=e.style.marginTop}return null!=n?n:void 0!==e.style.margin?e.style.margin:0}function _e(e,t){if(void 0!==e.style.borderStartWidth&&0<=e.style.borderStartWidth&&qe(t))return e.style.borderStartWidth;var n=null;switch(t){case"row":n=e.style.borderLeftWidth;break;case"row-reverse":n=e.style.borderRightWidth;break;case"column":n=e.style.borderTopWidth;break;case"column-reverse":n=e.style.borderBottomWidth}return null!=n&&0<=n?n:void 0!==e.style.borderWidth&&0<=e.style.borderWidth?e.style.borderWidth:0}function De(e,t){if(void 0!==e.style.borderEndWidth&&0<=e.style.borderEndWidth&&qe(t))return e.style.borderEndWidth;var n=null;switch(t){case"row":n=e.style.borderRightWidth;break;case"row-reverse":n=e.style.borderLeftWidth;break;case"column":n=e.style.borderBottomWidth;break;case"column-reverse":n=e.style.borderTopWidth}return null!=n&&0<=n?n:void 0!==e.style.borderWidth&&0<=e.style.borderWidth?e.style.borderWidth:0}function He(e,t){return function(e,t){if(void 0!==e.style.paddingStart&&0<=e.style.paddingStart&&qe(t))return e.style.paddingStart;var n=null;switch(t){case"row":n=e.style.paddingLeft;break;case"row-reverse":n=e.style.paddingRight;break;case"column":n=e.style.paddingTop;break;case"column-reverse":n=e.style.paddingBottom}return null!=n&&0<=n?n:void 0!==e.style.padding&&0<=e.style.padding?e.style.padding:0}(e,t)+_e(e,t)}function ze(e,t){return function(e,t){if(void 0!==e.style.paddingEnd&&0<=e.style.paddingEnd&&qe(t))return e.style.paddingEnd;var n=null;switch(t){case"row":n=e.style.paddingRight;break;case"row-reverse":n=e.style.paddingLeft;break;case"column":n=e.style.paddingBottom;break;case"column-reverse":n=e.style.paddingTop}return null!=n&&0<=n?n:void 0!==e.style.padding&&0<=e.style.padding?e.style.padding:0}(e,t)+De(e,t)}function Re(e,t){return Me(e,t)+$e(e,t)}function je(e,t){return He(e,t)+ze(e,t)}function Fe(e,t){return t.style.alignSelf?t.style.alignSelf:e.style.alignItems?e.style.alignItems:"stretch"}function Oe(e,t){if(t===n){if(e===lt)return ot;if(e===ot)return lt}return e}function Ge(e){return e.style.position?e.style.position:"relative"}function Pe(e){return Ge(e)===vt&&0<e.style.flex}function Ue(e,t){return e.layout[Et[t]]+Re(e,t)}function Ze(e,t){return void 0!==e.style[Et[t]]&&0<=e.style[Et[t]]}function Ve(e,t){return void 0!==e.style[t]}function Je(e,t){return void 0!==e.style[t]?e.style[t]:0}function Ke(e,t,n){var i={row:e.style.minWidth,"row-reverse":e.style.minWidth,column:e.style.minHeight,"column-reverse":e.style.minHeight}[t],r={row:e.style.maxWidth,"row-reverse":e.style.maxWidth,column:e.style.maxHeight,"column-reverse":e.style.maxHeight}[t],l=n;return void 0!==r&&0<=r&&r<l&&(l=r),void 0!==i&&0<=i&&l<i&&(l=i),l}function Qe(e,t){return t<e?e:t}function Xe(e,t){void 0===e.layout[Et[t]]&&Ze(e,t)&&(e.layout[Et[t]]=Qe(Ke(e,t,e.style[Et[t]]),je(e,t)))}function Ye(e,t,n){t.layout[wt[n]]=e.layout[Et[n]]-t.layout[Et[n]]-t.layout[Lt[n]]}function et(e,t){return void 0!==e.style[xt[t]]?Je(e,xt[t]):-Je(e,wt[t])}function l(e,t,n,i){var r,l,o,a,s,d,u=(o=i,(a=(l=e).style.direction?l.style.direction:it)===it&&(a=void 0===o?rt:o),a),c=Oe((r=e).style.flexDirection?r.style.flexDirection:at,u),y=(s=u,(d=c)===at||d===st?Oe(lt,s):at),h=Oe(lt,u);Xe(e,c),Xe(e,y),e.layout.direction=u,e.layout[xt[c]]+=Me(e,c)+et(e,c),e.layout[wt[c]]+=$e(e,c)+et(e,c),e.layout[xt[y]]+=Me(e,y)+et(e,y),e.layout[wt[y]]+=$e(e,y)+et(e,y);var f=e.children.length,m=je(e,h),g=je(e,at);if(void 0!==e.style.measure){var p=!Ie(e.layout[Et[h]]),v=nt;v=Ze(e,h)?e.style.width:p?e.layout[Et[h]]:t-Re(e,h),v-=m;var b=nt;b=Ze(e,at)?e.style.height:Ie(e.layout[Et[at]])?n-Re(e,h):e.layout[Et[at]],b-=je(e,at);var x=!Ze(e,h)&&!p,w=!Ze(e,at)&&Ie(e.layout[Et[at]]);if(x||w){var L=e.style.measure(v,b);x&&(e.layout.width=L.width+m),w&&(e.layout.height=L.height+g)}if(0===f)return}var E,S,W,C,k,A,N="wrap"===e.style.flexWrap,T=(k=e).style.justifyContent?k.style.justifyContent:"flex-start",B=He(e,c),I=He(e,y),q=je(e,c),M=je(e,y),$=!Ie(e.layout[Et[c]]),_=!Ie(e.layout[Et[y]]),D=qe(c),H=null,z=null,R=nt;$&&(R=e.layout[Et[c]]-q);for(var j=0,F=0,O=0,G=0,P=0,U=0;F<f;){var Z,V,J=0,K=0,Q=0,X=0,Y=$&&T===dt||!$&&T!==ut,ee=Y?f:j,te=!0,ne=f,ie=null,re=null,le=B,oe=0;for(E=j;E<f;++E){if((W=e.children[E]).lineIndex=U,W.nextAbsoluteChild=null,W.nextFlexChild=null,(me=Fe(e,W))===pt&&Ge(W)===vt&&_&&!Ze(W,y))W.layout[Et[y]]=Qe(Ke(W,y,e.layout[Et[y]]-M-Re(W,y)),je(W,y));else if(Ge(W)===bt)for(null===H&&(H=W),null!==z&&(z.nextAbsoluteChild=W),z=W,S=0;S<2;S++)C=0!==S?lt:at,!Ie(e.layout[Et[C]])&&!Ze(W,C)&&Ve(W,xt[C])&&Ve(W,wt[C])&&(W.layout[Et[C]]=Qe(Ke(W,C,e.layout[Et[C]]-je(e,C)-Re(W,C)-Je(W,xt[C])-Je(W,wt[C])),je(W,C)));var ae=0;if($&&Pe(W)?(K++,Q+=W.style.flex,null===ie&&(ie=W),null!==re&&(re.nextFlexChild=W),ae=je(re=W,c)+Re(W,c)):(V=Z=nt,D?V=Ze(e,at)?e.layout[Et[at]]-g:n-Re(e,at)-g:Z=Ze(e,h)?e.layout[Et[h]]-m:t-Re(e,h)-m,0===O&&tt(W,Z,V,u),Ge(W)===vt&&(X++,ae=Ue(W,c))),N&&$&&R<J+ae&&E!==j){X--,O=1;break}Y&&(Ge(W)!==vt||Pe(W))&&(Y=!1,ee=E),te&&(Ge(W)!==vt||me!==pt&&me!==ft||Ie(W.layout[Et[y]]))&&(te=!1,ne=E),Y&&(W.layout[Lt[c]]+=le,$&&Ye(e,W,c),le+=Ue(W,c),oe=Qe(oe,Ke(W,y,Ue(W,y)))),te&&(W.layout[Lt[y]]+=G+I,_&&Ye(e,W,y)),O=0,J+=ae,F=E+1}var se=0,de=0,ue=0;if(ue=$?R-J:Qe(J,0)-J,0!==K){var ce,ye,he=ue/Q;for(re=ie;null!==re;)(ce=he*re.style.flex+je(re,c))!==(ye=Ke(re,c,ce))&&(ue-=ye,Q-=re.style.flex),re=re.nextFlexChild;for((he=ue/Q)<0&&(he=0),re=ie;null!==re;)re.layout[Et[c]]=Ke(re,c,he*re.style.flex+je(re,c)),Z=nt,Ze(e,h)?Z=e.layout[Et[h]]-m:D||(Z=t-Re(e,h)-m),V=nt,Ze(e,at)?V=e.layout[Et[at]]-g:D&&(V=n-Re(e,at)-g),tt(re,Z,V,u),re=(W=re).nextFlexChild,W.nextFlexChild=null}else T!==dt&&(T===ut?se=ue/2:T===ct?se=ue:T===yt?(ue=Qe(ue,0),de=K+X-1!=0?ue/(K+X-1):0):T===ht&&(se=(de=ue/(K+X))/2));for(le+=se,E=ee;E<F;++E)Ge(W=e.children[E])===bt&&Ve(W,xt[c])?W.layout[Lt[c]]=Je(W,xt[c])+_e(e,c)+Me(W,c):(W.layout[Lt[c]]+=le,$&&Ye(e,W,c),Ge(W)===vt&&(le+=de+Ue(W,c),oe=Qe(oe,Ke(W,y,Ue(W,y)))));var fe=e.layout[Et[y]];for(_||(fe=Qe(Ke(e,y,oe+M),M)),E=ne;E<F;++E)if(Ge(W=e.children[E])===bt&&Ve(W,xt[y]))W.layout[Lt[y]]=Je(W,xt[y])+_e(e,y)+Me(W,y);else{var me,ge=I;if(Ge(W)===vt)if((me=Fe(e,W))===pt)Ie(W.layout[Et[y]])&&(W.layout[Et[y]]=Qe(Ke(W,y,fe-M-Re(W,y)),je(W,y)));else if(me!==ft){var pe=fe-M-Ue(W,y);ge+=me===mt?pe/2:pe}W.layout[Lt[y]]+=G+ge,_&&Ye(e,W,y)}G+=oe,P=Qe(P,le),U+=1,j=F}if(1<U&&_){var ve=e.layout[Et[y]]-M,be=ve-G,xe=0,we=I,Le=(A=e).style.alignContent?A.style.alignContent:"flex-start";Le===gt?we+=be:Le===mt?we+=be/2:Le===pt&&G<ve&&(xe=be/U);var Ee=0;for(E=0;E<U;++E){var Se=Ee,We=0;for(S=Se;S<f;++S)if(Ge(W=e.children[S])===vt){if(W.lineIndex!==E)break;Ie(W.layout[Et[y]])||(We=Qe(We,W.layout[Et[y]]+Re(W,y)))}for(Ee=S,We+=xe,S=Se;S<Ee;++S)if(Ge(W=e.children[S])===vt){var Ce=Fe(e,W);if(Ce===ft)W.layout[Lt[y]]=we+Me(W,y);else if(Ce===gt)W.layout[Lt[y]]=we+We-$e(W,y)-W.layout[Et[y]];else if(Ce===mt){var ke=W.layout[Et[y]];W.layout[Lt[y]]=we+(We-ke)/2}else Ce===pt&&(W.layout[Lt[y]]=we+Me(W,y))}we+=We}}var Ae,Ne,Te=!1,Be=!1;if($||(e.layout[Et[c]]=Qe(Ke(e,c,P+ze(e,c)),q),(c===ot||c===st)&&(Te=!0)),_||(e.layout[Et[y]]=Qe(Ke(e,y,G+M),M),(y===ot||y===st)&&(Be=!0)),Te||Be)for(E=0;E<f;++E)W=e.children[E],Te&&Ye(e,W,c),Be&&Ye(e,W,y);for(z=H;null!==z;){for(S=0;S<2;S++)C=0!==S?lt:at,!Ie(e.layout[Et[C]])&&!Ze(z,C)&&Ve(z,xt[C])&&Ve(z,wt[C])&&(z.layout[Et[C]]=Qe(Ke(z,C,e.layout[Et[C]]-(_e(Ae=e,Ne=C)+De(Ae,Ne))-Re(z,C)-Je(z,xt[C])-Je(z,wt[C])),je(z,C))),Ve(z,wt[C])&&!Ve(z,xt[C])&&(z.layout[xt[C]]=e.layout[Et[C]]-z.layout[Et[C]]-Je(z,wt[C]));z=(W=z).nextAbsoluteChild,W.nextAbsoluteChild=null}}function tt(e,t,n,i){e.shouldUpdate=!0;var r=e.style.direction||rt;!e.isDirty&&e.lastLayout&&e.lastLayout.requestedHeight===e.layout.height&&e.lastLayout.requestedWidth===e.layout.width&&e.lastLayout.parentMaxWidth===t&&e.lastLayout.parentMaxHeight===n&&e.lastLayout.direction===r?(e.layout.width=e.lastLayout.width,e.layout.height=e.lastLayout.height,e.layout.top=e.lastLayout.top,e.layout.left=e.lastLayout.left):(e.lastLayout||(e.lastLayout={}),e.lastLayout.requestedWidth=e.layout.width,e.lastLayout.requestedHeight=e.layout.height,e.lastLayout.parentMaxWidth=t,e.lastLayout.parentMaxHeight=n,e.lastLayout.direction=r,e.children.forEach(function(e){e.layout.width=void 0,e.layout.height=void 0,e.layout.top=0,e.layout.left=0}),l(e,t,n,i),e.lastLayout.width=e.layout.width,e.lastLayout.height=e.layout.height,e.lastLayout.top=e.layout.top,e.lastLayout.left=e.layout.left)}var nt,it="inherit",rt="ltr",n="rtl",lt="row",ot="row-reverse",at="column",st="column-reverse",dt="flex-start",ut="center",ct="flex-end",yt="space-between",ht="space-around",ft="flex-start",mt="center",gt="flex-end",pt="stretch",vt="relative",bt="absolute",xt={row:"left","row-reverse":"right",column:"top","column-reverse":"bottom"},wt={row:"right","row-reverse":"left",column:"bottom","column-reverse":"top"},Lt={row:"left","row-reverse":"right",column:"top","column-reverse":"bottom"},Et={row:"width","row-reverse":"width",column:"height","column-reverse":"height"};return{layoutNodeImpl:l,computeLayout:tt,fillNodes:function e(t){if((!t.layout||t.isDirty)&&(t.layout={width:void 0,height:void 0,top:0,left:0,right:0,bottom:0}),t.style||(t.style={}),t.children||(t.children=[]),t.style.measure&&t.children&&t.children.length)throw new Error("Using custom measure function is supported only for leaf nodes.");return t.children.forEach(e),t}}}();return"object"==typeof exports&&(module.exports=t),function(e){t.fillNodes(e),t.computeLayout(e)}},"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?module.exports=t():e.computeLayout=t(),!window.addEventListener&&window.attachEvent&&(Window.prototype.addEventListener=HTMLDocument.prototype.addEventListener=Element.prototype.addEventListener=function(e,t){this.attachEvent("on"+e,t)},Window.prototype.removeEventListener=HTMLDocument.prototype.removeEventListener=Element.prototype.removeEventListener=function(e,t){this.detachEvent("on"+e,t)}),flexibility.detect=function(){var e=document.createElement("p");try{return(e.style.display="flex")===e.style.display}catch(e){return!1}},!flexibility.detect()&&document.attachEvent&&document.documentElement.currentStyle&&document.attachEvent("onreadystatechange",function(){flexibility.onresize({target:document.documentElement})}),flexibility.init=function(e){var t=e.onlayoutcomplete;return t||(t=e.onlayoutcomplete={node:e,style:{},children:[]}),t.style.display=e.currentStyle["-js-display"]||e.currentStyle.display,t};var n,i=document.documentElement,r=0,l=0;flexibility.onresize=function(e){if(i.clientWidth!==r||i.clientHeight!==l){r=i.clientWidth,l=i.clientHeight,clearTimeout(n),window.removeEventListener("resize",flexibility.onresize);var t=e.target&&1===e.target.nodeType?e.target:document.documentElement;flexibility.walk(t),n=setTimeout(function(){window.addEventListener("resize",flexibility.onresize)},1e3/15)}};var d={alignContent:{initial:"stretch",valid:/^(flex-start|flex-end|center|space-between|space-around|stretch)/},alignItems:{initial:"stretch",valid:/^(flex-start|flex-end|center|baseline|stretch)$/},boxSizing:{initial:"content-box",valid:/^(border-box|content-box)$/},flexDirection:{initial:"row",valid:/^(row|row-reverse|column|column-reverse)$/},flexWrap:{initial:"nowrap",valid:/^(nowrap|wrap|wrap-reverse)$/},justifyContent:{initial:"flex-start",valid:/^(flex-start|flex-end|center|space-between|space-around)$/}};flexibility.updateFlexContainerCache=function(e){var t=e.style,n=e.node.currentStyle,i=e.node.style,r={};for(var l in(n["flex-flow"]||i["flex-flow"]||"").replace(/^(row|row-reverse|column|column-reverse)\s+(nowrap|wrap|wrap-reverse)$/i,function(e,t,n){r.flexDirection=t,r.flexWrap=n}),d){var o=l.replace(/[A-Z]/g,"-$&").toLowerCase(),a=d[l],s=n[o]||i[o];t[l]=a.valid.test(s)?s:r[l]||a.initial}};var u={alignSelf:{initial:"auto",valid:/^(auto|flex-start|flex-end|center|baseline|stretch)$/},boxSizing:{initial:"content-box",valid:/^(border-box|content-box)$/},flexBasis:{initial:"auto",valid:/^((?:[-+]?0|[-+]?[0-9]*\.?[0-9]+(?:%|ch|cm|em|ex|in|mm|pc|pt|px|rem|vh|vmax|vmin|vw))|auto|fill|max-content|min-content|fit-content|content)$/},flexGrow:{initial:0,valid:/^\+?(0|[1-9][0-9]*)$/},flexShrink:{initial:0,valid:/^\+?(0|[1-9][0-9]*)$/},order:{initial:0,valid:/^([-+]?[0-9]+)$/}};flexibility.updateFlexItemCache=function(e){var t=e.style,n=e.node.currentStyle,i=e.node.style,r={};for(var l in(n.flex||i.flex||"").replace(/^\+?(0|[1-9][0-9]*)/,function(e){r.flexGrow=e}),u){var o=l.replace(/[A-Z]/g,"-$&").toLowerCase(),a=u[l],s=n[o]||i[o];t[l]=a.valid.test(s)?s:r[l]||a.initial,"number"==typeof a.initial&&(t[l]=parseFloat(t[l]))}};var y={medium:4,none:0,thick:6,thin:2},h={borderBottomWidth:0,borderLeftWidth:0,borderRightWidth:0,borderTopWidth:0,height:0,paddingBottom:0,paddingLeft:0,paddingRight:0,paddingTop:0,marginBottom:0,marginLeft:0,marginRight:0,marginTop:0,maxHeight:0,maxWidth:0,minHeight:0,minWidth:0,width:0},f=/^([-+]?0|[-+]?[0-9]*\.?[0-9]+)/;flexibility.updateLengthCache=function(e){var t,n,i,r=e.node,l=e.style,o=r.parentNode,a=document.createElement("_"),s=a.runtimeStyle,d=r.currentStyle;for(var u in s.cssText="border:0 solid;clip:rect(0 0 0 0);display:inline-block;font:0/0 serif;margin:0;max-height:none;max-width:none;min-height:0;min-width:0;overflow:hidden;padding:0;position:absolute;width:1em;font-size:"+d.fontSize,o.insertBefore(a,r.nextSibling),l.fontSize=a.offsetWidth,s.fontSize=l.fontSize+"px",h){var c=d[u];f.test(c)||"auto"===c&&!/(width|height)/i.test(u)?/%$/.test(c)?(/^(bottom|height|top)$/.test(u)?(n||(n=o.offsetHeight),i=n):(t||(t=o.offsetWidth),i=t),l[u]=parseFloat(c)*i/100):(s.width=c,l[u]=a.offsetWidth):/^border/.test(u)&&c in y?l[u]=y[c]:delete l[u]}o.removeChild(a),"none"===d.borderTopStyle&&(l.borderTopWidth=0),"none"===d.borderRightStyle&&(l.borderRightWidth=0),"none"===d.borderBottomStyle&&(l.borderBottomWidth=0),"none"===d.borderLeftStyle&&(l.borderLeftWidth=0),l.width||l.minWidth||(/flex/.test(l.display)?l.width=r.offsetWidth:l.minWidth=r.offsetWidth),l.height||l.minHeight||/flex/.test(l.display)||(l.minHeight=r.offsetHeight)},flexibility.walk=function(e){var r=flexibility.init(e),l=r.style,t=l.display;if("none"===t)return{};var o=t.match(/^(inline)?flex$/);if(o&&(flexibility.updateFlexContainerCache(r),e.runtimeStyle.cssText="display:"+(o[1]?"inline-block":"block"),r.children=[]),Array.prototype.forEach.call(e.childNodes,function(e,t){if(1===e.nodeType){var n=flexibility.walk(e),i=n.style;n.index=t,o&&(flexibility.updateFlexItemCache(n),"auto"===i.alignSelf&&(i.alignSelf=l.alignItems),i.flex=i.flexGrow,e.runtimeStyle.cssText="display:inline-block",r.children.push(n))}}),o){r.children.forEach(function(e){flexibility.updateLengthCache(e)}),r.children.sort(function(e,t){return e.style.order-t.style.order||e.index-t.index}),/-reverse$/.test(l.flexDirection)&&(r.children.reverse(),l.flexDirection=l.flexDirection.replace(/-reverse$/,""),"flex-start"===l.justifyContent?l.justifyContent="flex-end":"flex-end"===l.justifyContent&&(l.justifyContent="flex-start")),flexibility.updateLengthCache(r),delete r.lastLayout,delete r.layout;var n=l.borderTopWidth,i=l.borderBottomWidth;l.borderTopWidth=0,l.borderBottomWidth=0,l.borderLeftWidth=0,"column"===l.flexDirection&&(l.width-=l.borderRightWidth),flexibility.computeLayout(r),e.runtimeStyle.cssText="box-sizing:border-box;display:block;position:relative;width:"+(r.layout.width+l.borderRightWidth)+"px;height:"+(r.layout.height+n+i)+"px";var a=[],s=1,d="column"===l.flexDirection?"width":"height";r.children.forEach(function(e){a[e.lineIndex]=Math.max(a[e.lineIndex]||0,e.layout[d]),s=Math.max(s,e.lineIndex+1)}),r.children.forEach(function(e){var t=e.layout;"stretch"===e.style.alignSelf&&(t[d]=a[e.lineIndex]),e.node.runtimeStyle.cssText="box-sizing:border-box;display:block;position:absolute;margin:0;width:"+t.width+"px;height:"+t.height+"px;top:"+t.top+"px;left:"+t.left+"px"})}return r}}();var isIE=!1,isEdge=!1,getParents=function(e,t){Element.prototype.matches||(Element.prototype.matches=Element.prototype.matchesSelector||Element.prototype.mozMatchesSelector||Element.prototype.msMatchesSelector||Element.prototype.oMatchesSelector||Element.prototype.webkitMatchesSelector||function(e){for(var t=(this.document||this.ownerDocument).querySelectorAll(e),n=t.length;0<=--n&&t.item(n)!==this;);return-1<n});for(var n=[];e&&e!==document;e=e.parentNode)t?e.matches(t)&&n.push(e):n.push(e);return n},toggleClass=function(e,t){e.classList.contains(t)?e.classList.remove(t):e.classList.add(t)};!function(){function e(e,t){t=t||{bubbles:!1,cancelable:!1,detail:void 0};var n=document.createEvent("CustomEvent");return n.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),n}isIE=!!document.documentMode,isEdge=!isIE&&!!window.StyleMedia,"function"!=typeof window.CustomEvent&&(e.prototype=window.Event.prototype,window.CustomEvent=e)}(),function(){AstraNavigationMenu=function(e){for(var t=0;t<e.length;t++)if(null!=e[t].querySelector(".sub-menu, .children")){var n=document.createElement("BUTTON");n.setAttribute("role","button"),n.setAttribute("class","ast-menu-toggle"),n.setAttribute("aria-expanded","false"),n.innerHTML="<span class='screen-reader-text'>Menu Toggle</span>",e[t].insertBefore(n,e[t].childNodes[1]);var i=e[t].getBoundingClientRect().left,r=window.innerWidth,l=parseInt(r)-parseInt(i),o=!1;if(l<500&&(o=!0),o){e[t].classList.add("ast-left-align-sub-menu");for(var a=e[t].querySelectorAll(".menu-item-has-children, .page_item_has_children"),s=0;s<a.length;s++)a[s].classList.add("ast-left-align-sub-menu")}l<240&&e[t].classList.add("ast-sub-menu-goes-outside")}},AstraToggleMenu=function(e){for(var t=0;t<e.length;t++)e[t].addEventListener("click",function(e){e.preventDefault();for(var t=this.parentNode,n=t.querySelectorAll(".menu-item-has-children, .page_item_has_children"),i=0;i<n.length;i++)n[i].classList.remove("ast-submenu-expanded"),n[i].querySelector(".sub-menu, .children").style.display="none";var r=t.parentNode.querySelectorAll(".menu-item-has-children, .page_item_has_children");for(i=0;i<r.length;i++)if(r[i]!=t){r[i].classList.remove("ast-submenu-expanded");for(var l=r[i].querySelectorAll(".sub-menu, .children"),o=0;o<l.length;o++)l[o].style.display="none"}(t.classList.contains("menu-item-has-children")||t.classList.contains("page_item_has_children"))&&(toggleClass(t,"ast-submenu-expanded"),t.classList.contains("ast-submenu-expanded")?t.querySelector(".sub-menu, .children").style.display="block":t.querySelector(".sub-menu, .children").style.display="none")},!1)};var a=document.querySelectorAll(".main-header-bar-navigation"),o=document.querySelectorAll(".main-header-menu-toggle");if(0<o.length)for(var e=0;e<o.length;e++)if(o[e].setAttribute("data-index",e),o[e].addEventListener("click",function(e){e.preventDefault();var t=this.getAttribute("data-index");if(void 0===a[t])return!1;for(var n=a[t].querySelectorAll(".menu-item-has-children, .page_item_has_children"),i=0;i<n.length;i++){n[i].classList.remove("ast-submenu-expanded");for(var r=n[i].querySelectorAll(".sub-menu, .children"),l=0;l<r.length;l++)r[l].style.display="none"}switch(this.getAttribute("rel")||""){case"main-menu":toggleClass(a[t],"toggle-on"),toggleClass(o[t],"toggled"),a[t].classList.contains("toggle-on")?a[t].style.display="block":a[t].style.display=""}},!1),void 0!==a[e]){var t=a[e].querySelectorAll("ul.main-header-menu li");AstraNavigationMenu(t);var n=a[e].querySelectorAll("ul.main-header-menu .ast-menu-toggle");AstraToggleMenu(n)}document.body.addEventListener("astra-header-responsive-enabled",function(){if(0<a.length)for(var e=0;e<a.length;e++){null!=a[e]&&(a[e].classList.remove("toggle-on"),a[e].style.display="");for(var t=a[e].getElementsByClassName("sub-menu"),n=0;n<t.length;n++)t[n].style.display="";for(var i=a[e].getElementsByClassName("children"),r=0;r<i.length;r++)i[r].style.display="";for(var l=a[e].getElementsByClassName("ast-search-menu-icon"),o=0;o<l.length;o++)l[o].classList.remove("ast-dropdown-active"),l[o].style.display=""}},!1);var i=function(){var e=astra.break_point,t=document.querySelectorAll(".main-header-bar-wrap");if(0<t.length)for(var n=0;n<t.length;n++)if("DIV"==t[n].tagName&&t[n].classList.contains("main-header-bar-wrap")){var i=window.getComputedStyle(t[n]).content;if((isEdge||isIE||"normal"===i)&&window.innerWidth<=e&&(i=e),i=i.replace(/[^0-9]/g,""),(i=parseInt(i))!=e){null!=o[n]&&o[n].classList.remove("toggled"),document.body.classList.remove("ast-header-break-point");var r=new CustomEvent("astra-header-responsive-enabled");document.body.dispatchEvent(r)}else{document.body.classList.add("ast-header-break-point");var l=new CustomEvent("astra-header-responsive-disabled");document.body.dispatchEvent(l)}}};window.addEventListener("resize",function(){i()}),i();var r,l,s,d,u,c,y=document.getElementsByClassName("astra-search-icon");for(e=0;e<y.length;e++)y[e].onclick=function(e){if(this.classList.contains("slide-search")){e.preventDefault();var t=this.parentNode.parentNode.querySelector(".ast-search-menu-icon");t.classList.contains("ast-dropdown-active")?t.classList.remove("ast-dropdown-active"):(t.classList.add("ast-dropdown-active"),t.querySelector(".search-field").setAttribute("autocomplete","off"),setTimeout(function(){t.querySelector(".search-field").focus()},200))}};if(document.body.onclick=function(e){if(!this.classList.contains("ast-header-break-point")&&!e.target.classList.contains("ast-search-menu-icon")&&0===getParents(e.target,".ast-search-menu-icon").length&&0===getParents(e.target,".ast-search-icon").length)for(var t=document.getElementsByClassName("ast-search-menu-icon"),n=0;n<t.length;n++)t[n].classList.remove("ast-dropdown-active")},(r=document.getElementById("site-navigation"))&&void 0!==(l=r.getElementsByTagName("button")[0]))if(void 0!==(s=r.getElementsByTagName("ul")[0])){for(s.setAttribute("aria-expanded","false"),-1===s.className.indexOf("nav-menu")&&(s.className+=" nav-menu"),l.onclick=function(){-1!==r.className.indexOf("toggled")?(r.className=r.className.replace(" toggled",""),l.setAttribute("aria-expanded","false"),s.setAttribute("aria-expanded","false")):(r.className+=" toggled",l.setAttribute("aria-expanded","true"),s.setAttribute("aria-expanded","true"))},d=s.getElementsByTagName("a"),e=0,c=(u=s.getElementsByTagName("ul")).length;e<c;e++)u[e].parentNode.setAttribute("aria-haspopup","true");for(e=0,c=d.length;e<c;e++)d[e].addEventListener("focus",h,!0),d[e].addEventListener("blur",h,!0);!function(e){var t,n,i=r.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a");if("ontouchstart"in window)for(t=function(e){var t,n=this.parentNode;if(n.classList.contains("focus"))n.classList.remove("focus");else{for(e.preventDefault(),t=0;t<n.parentNode.children.length;++t)n!==n.parentNode.children[t]&&n.parentNode.children[t].classList.remove("focus");n.classList.add("focus")}},n=0;n<i.length;++n)i[n].addEventListener("touchstart",t,!1)}()}else l.style.display="none";function h(){for(var e=this;-1===e.className.indexOf("nav-menu");)"li"===e.tagName.toLowerCase()&&(-1!==e.className.indexOf("focus")?e.className=e.className.replace(" focus",""):e.className+=" focus"),e=e.parentElement}}(),function(){var e=-1<navigator.userAgent.toLowerCase().indexOf("webkit"),t=-1<navigator.userAgent.toLowerCase().indexOf("opera"),n=-1<navigator.userAgent.toLowerCase().indexOf("msie");(e||t||n)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var e,t=location.hash.substring(1);/^[A-z0-9_-]+$/.test(t)&&(e=document.getElementById(t))&&(/^(?:a|select|input|button|textarea)$/i.test(e.tagName)||(e.tabIndex=-1),e.focus())},!1)}();