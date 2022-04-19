ace.define("ace/ext/beautify",["require","exports","module","ace/token_iterator"],(function(e,t,r){"use strict";var a=e("../token_iterator").TokenIterator;function o(e,t){return e.type.lastIndexOf(t+".xml")>-1}t.singletonTags=["area","base","br","col","command","embed","hr","html","img","input","keygen","link","meta","param","source","track","wbr"],t.blockTags=["article","aside","blockquote","body","div","dl","fieldset","footer","form","head","header","html","nav","ol","p","script","section","style","table","tbody","tfoot","thead","ul"],t.beautify=function(e){for(var r,s,n,i=new a(e,0,0),c=i.getCurrentToken(),u=e.getTabString(),l=t.singletonTags,m=t.blockTags,p=!1,f=!1,h=!1,y="",d="",g="",b=0,k=0,$=0,w=0,x=0,v=0,T=0,R=0,O=0,q=!1,C=!1,I=!1,_=!1,j={0:0},B=[],F=!1,S=function(){r&&r.value&&"string.regexp"!==r.type&&(r.value=r.value.replace(/^\s*/,""))},K=function(){for(var e=y.length-1;0!=e&&" "===y[e];)e-=1;y=y.slice(0,e+1)},L=function(){y=y.trimRight(),p=!1};null!==c;){if(R=i.getCurrentTokenRow(),i.$rowTokens,r=i.stepForward(),void 0!==c){if(d=c.value,x=0,I="style"===g||"ace/mode/css"===e.$modeId,o(c,"tag-open")?(C=!0,r&&(_=-1!==m.indexOf(r.value)),"</"===d&&(_&&!p&&O<1&&O++,I&&(O=1),x=1,_=!1)):o(c,"tag-close")?C=!1:o(c,"comment.start")?_=!0:o(c,"comment.end")&&(_=!1),C||O||"paren.rparen"!==c.type||"}"!==c.value.substr(0,1)||O++,R!==s&&(O=R,s&&(O-=s)),O){for(L();O>0;O--)y+="\n";p=!0,o(c,"comment")||c.type.match(/^(comment|string)$/)||(d=d.trimLeft())}if(d){if("keyword"===c.type&&d.match(/^(if|else|elseif|for|foreach|while|switch)$/)?(B[b]=d,S(),h=!0,d.match(/^(else|elseif)$/)&&y.match(/\}[\s]*$/)&&(L(),f=!0)):"paren.lparen"===c.type?(S(),"{"===d.substr(-1)&&(h=!0,q=!1,C||(O=1)),"{"===d.substr(0,1)&&(f=!0,"["!==y.substr(-1)&&"["===y.trimRight().substr(-1)?(L(),f=!1):")"===y.trimRight().substr(-1)?L():K())):"paren.rparen"===c.type?(x=1,"}"===d.substr(0,1)&&("case"===B[b-1]&&x++,"{"===y.trimRight().substr(-1)?L():(f=!0,I&&(O+=2))),"]"===d.substr(0,1)&&"}"!==y.substr(-1)&&"}"===y.trimRight().substr(-1)&&(f=!1,w++,L()),")"===d.substr(0,1)&&"("!==y.substr(-1)&&"("===y.trimRight().substr(-1)&&(f=!1,w++,L()),K()):"keyword.operator"!==c.type&&"keyword"!==c.type||!d.match(/^(=|==|===|!=|!==|&&|\|\||and|or|xor|\+=|.=|>|>=|<|<=|=>)$/)?"punctuation.operator"===c.type&&";"===d?(L(),S(),h=!0,I&&O++):"punctuation.operator"===c.type&&d.match(/^(:|,)$/)?(L(),S(),d.match(/^(,)$/)&&T>0&&0===v?O++:(h=!0,p=!1)):"support.php_tag"!==c.type||"?>"!==d||p?o(c,"attribute-name")&&y.substr(-1).match(/^\s$/)?f=!0:o(c,"attribute-equals")?(K(),S()):o(c,"tag-close")?(K(),"/>"===d&&(f=!0)):"keyword"===c.type&&d.match(/^(case|default)$/)&&F&&(x=1):(L(),f=!0):(L(),S(),f=!0,h=!0),p&&(!c.type.match(/^(comment)$/)||d.substr(0,1).match(/^[/#]$/))&&(!c.type.match(/^(string)$/)||d.substr(0,1).match(/^['"@]$/))){if(w=$,b>k)for(w++,n=b;n>k;n--)j[n]=w;else b<k&&(w=j[b]);for(k=b,$=w,x&&(w-=x),q&&!v&&(w++,q=!1),n=0;n<w;n++)y+=u}if("keyword"===c.type&&d.match(/^(case|default)$/)?!1===F&&(B[b]=d,b++,F=!0):"keyword"===c.type&&d.match(/^(break)$/)&&B[b-1]&&B[b-1].match(/^(case|default)$/)&&(b--,F=!1),"paren.lparen"===c.type&&(v+=(d.match(/\(/g)||[]).length,T+=(d.match(/\{/g)||[]).length,b+=d.length),"keyword"===c.type&&d.match(/^(if|else|elseif|for|while)$/)?(q=!0,v=0):!v&&d.trim()&&"comment"!==c.type&&(q=!1),"paren.rparen"===c.type)for(v-=(d.match(/\)/g)||[]).length,T-=(d.match(/\}/g)||[]).length,n=0;n<d.length;n++)b--,"}"===d.substr(n,1)&&"case"===B[b]&&b--;"text"==c.type&&(d=d.replace(/\s+$/," ")),f&&!p&&(K(),"\n"!==y.substr(-1)&&(y+=" ")),y+=d,h&&(y+=" "),p=!1,f=!1,h=!1,(o(c,"tag-close")&&(_||-1!==m.indexOf(g))||o(c,"doctype")&&">"===d)&&(O=_&&r&&"</"===r.value?-1:1),o(c,"tag-open")&&"</"===d?b--:o(c,"tag-open")&&"<"===d&&-1===l.indexOf(r.value)?b++:o(c,"tag-name")?g=d:o(c,"tag-close")&&"/>"===d&&-1===l.indexOf(g)&&b--,s=R}}c=r}y=y.trim(),e.doc.setValue(y)},t.commands=[{name:"beautify",description:"Format selection (Beautify)",exec:function(e){t.beautify(e.session)},bindKey:"Ctrl-Shift-B"}]})),ace.require(["ace/ext/beautify"],(function(e){"object"==typeof module&&"object"==typeof exports&&module&&(module.exports=e)}));