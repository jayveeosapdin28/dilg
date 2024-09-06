import{o as s,g as o,b as a,d as p,t as b,a as m,w as v,I as S,n as f,u as d,i as _,F as g,s as x,f as V,J as U,K as G,k as L,h as z,Q as H,l as K,r as R,j as $,c as O,D as W}from"./app-D5M1G0zN.js";import{l as X}from"./lodash-6vzRCwDD.js";import{_ as Y}from"./_plugin-vue_export-helper-DlAUqK2U.js";const j=e=>(U("data-v-9f72af49"),e=e(),G(),e),Z={class:"block font-semibold text-lg sm:flex items-center text-center justify-between pt-0 text-accent","aria-label":"Table navigation"},P={class:"text-sm text-primary-500"},q={class:""},ee={class:""},te=j(()=>a("span",null," entries",-1)),le={class:"flex items-center justify-center gap-1 h-8 text-sm"},ae=j(()=>a("i",{class:"bi bi-chevron-left"},null,-1)),re={key:0},se=j(()=>a("i",{class:"bi bi-chevron-right"},null,-1)),ne={__name:"Pagination",props:{links:{type:Array,default:0},next_page_url:{type:String,default:null},current_page:{type:Number,default:null},prev_page_url:{type:String,default:null},total:{type:Number,default:null},from:{type:Number,default:null},to:{type:Number,default:null},preserveScroll:{type:Boolean}},setup(e){const c=e,t=l=>{const y=parseInt(c.current_page);return Math.abs(l-y)<=2||l===1||l===parseInt(c.total)};return(l,y)=>(s(),o("nav",Z,[a("span",P,[p("Showing "),a("span",q,b(`${e.from} to ${e.to}`),1),p(" of "),a("span",ee,b(e.total),1),te]),a("nav",null,[a("ul",le,[a("li",null,[m(d(_),{style:S({"pointer-events":e.prev_page_url==null?"none":"auto"}),href:e.prev_page_url,class:f(["flex text-accent items-center rounded-full justify-center link px-3 h-8 w-8 ml-0 leading-tight bg-white hover:text-white hover:bg-primary-300 border border-primary-300",{"text-primary-200":!e.prev_page_url}]),"preserve-scroll":e.preserveScroll},{default:v(()=>[ae]),_:1},8,["style","href","class","preserve-scroll"])]),(s(!0),o(g,null,x(e.links,u=>(s(),o(g,{key:u.label},[!isNaN(u.label)&&t(u.label)?(s(),o("li",re,[m(d(_),{href:u.url,"preserve-scroll":e.preserveScroll,class:f([{"active bg-primary-500 hover:!bg-primary-300":u.active},"flex items-center rounded-full justify-center px-4 w-8 h-8 text-primary-500 border border-primary-300 hover:bg-primary-300 hover:text-white"])},{default:v(()=>[p(b(u.label),1)]),_:2},1032,["href","preserve-scroll","class"])])):V("",!0)],64))),128)),a("li",null,[m(d(_),{style:S({"pointer-events":e.next_page_url==null?"none":"auto"}),href:e.next_page_url,class:f(["flex items-center rounded-full justify-center link px-3 h-8 w-8 ml-0 leading-tight text-primary-500 bg-white hover:text-white hover:bg-primary-300 border border-primary-500",{"text-primary-200":!e.next_page_url}]),"preserve-scroll":e.preserveScroll},{default:v(()=>[se]),_:1},8,["style","href","class","preserve-scroll"])])])])]))}},oe=Y(ne,[["__scopeId","data-v-9f72af49"]]),ie={class:""},ce={class:"mb-4 flex justify-between items-center"},ue={class:"min-w-72"},de={class:"rounded border-b"},fe=["align","onClick"],ye={key:0},he=a("td",{colspan:"99",class:"text-center py-6 px-3 text-sm text-gray-600"},[a("div",{class:"flex justify-center items-center"},[a("div",{class:""},[a("img",{class:"w-[10rem] opacity-40",src:"/img/default/empty-box.png"}),a("p",{class:"text-gray-300 text-lg mt-3"},"Data not found")])])],-1),pe=[he],be={class:"even:bg-primary-50 rounded hover:bg-primary-100"},ge=["align"],me={class:"mt-8"},je={__name:"DataTable",props:{columns:Array,data:Object,modelValue:String,withPagination:{type:Boolean,default:!0},searchPlaceholder:{type:String,default:"Search"},filterLink:String},setup(e){var N,D,I,B,A;const c=e;L(null);const t=z(()=>H().props.request);let l=L({query:((N=t==null?void 0:t.value)==null?void 0:N.query)??null,order_by:((D=t==null?void 0:t.value)==null?void 0:D.order_by)??null,sort_by:((I=t==null?void 0:t.value)==null?void 0:I.sort_by)??null,pages:((B=t==null?void 0:t.value)==null?void 0:B.pages)??10,page:((A=t==null?void 0:t.value)==null?void 0:A.page)??null});const y=async()=>{let r={...l.value};await M(r),W.get(c.filterLink,r,{preserveState:!0,preserveScroll:!0})},u=(r,i)=>{w(),i||(r===l.value.sort_by?l.value.order_by=l.value.order_by=="asc"?"desc":"asc":(l.value.sort_by=r,l.value.order_by="asc"),C())};z({set:r=>{emit("update:modelValue",r)},get:()=>c.modelValue});const Q=r=>r===l.value.sort_by?`sorted-${l.value.order_by}`:"",J=()=>l.value.order_by==="asc"?"bi bi-arrow-up":"bi bi-arrow-down";function M(r){for(const i in r)(Array.isArray(r[i])&&r[i].length===0||r[i]===null||r[i]==="")&&delete r[i]}const w=()=>{l.value.page=1},C=X.debounce((r,i)=>{y(),w()},100);return K(l,(r,i)=>{C()},{deep:!0}),K(()=>c.modelValue,(r,i)=>{Object.keys(l.value).forEach(k=>{l.value[k]=null}),y(),w()}),(r,i)=>{var E,F,T;const k=R("VTextField");return s(),o("div",ie,[a("div",ce,[a("div",ue,[m(k,{variant:"outlined",density:"compact",clearable:"",color:"primary",modelValue:d(l).query,"onUpdate:modelValue":i[0]||(i[0]=n=>d(l).query=n),label:e.searchPlaceholder},null,8,["modelValue","label"])]),$(r.$slots,"table-toolbar")]),a("table",{class:f(["w-full",{"h-[calc(30vh)]":e.data&&((E=e.data.data)==null?void 0:E.length)<1}])},[a("thead",de,[(s(!0),o(g,null,x(e.columns,n=>(s(),o("th",{align:n.align?n.align:"left",class:f(["text-sm font-semibold uppercase cursor-pointer text-gray-500 p-3",Q(n.field)]),style:S({width:n.width??null}),onClick:h=>n.sortable!=="No"?u(n.field,n.prevent_sort):null},[d(l).sort_by===n.field&&!n.prevent_sort?(s(),o("i",{key:0,class:f(J())},null,2)):V("",!0),p(" "+b(n.label),1)],14,fe))),256)),$(r.$slots,"table-header")]),a("tbody",null,[e.data&&((F=e.data.data)==null?void 0:F.length)<1?(s(),o("tr",ye,pe)):(s(!0),o(g,{key:1},x(e.data.data,n=>(s(),o("tr",be,[(s(!0),o(g,null,x(e.columns,h=>(s(),o("td",{align:h.align?h.align:"left",class:"p-3 text-sm text-gray-600"},[$(r.$slots,`column_${h.field}`,{props:n},()=>[p(b(n[h.field]),1)])],8,ge))),256))]))),256))])],2),a("div",me,[e.data&&((T=e.data.data)==null?void 0:T.length)>0&&e.withPagination?(s(),O(oe,{key:0,total:e.data.total??0,from:e.data.from??0,to:e.data.to??0,links:e.data.links??[],current_page:e.data.current_page??null,next_page_url:e.data.next_page_url??"#",prev_page_url:e.data.prev_page_url??"#"},null,8,["total","from","to","links","current_page","next_page_url","prev_page_url"])):V("",!0)])])}}},ve=a("i",{class:"bi bi-trash text-red-500"},null,-1),_e=[ve],Ce={__name:"ActionDelete",emits:["click"],setup(e){return(c,t)=>(s(),o("button",{onClick:t[0]||(t[0]=l=>c.$emit("click")),class:"hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full"},_e))}},xe=a("i",{class:"bi bi-pencil-square text-blue-500"},null,-1),we=a("i",{class:"bi bi-pencil-square text-blue-500"},null,-1),ke=[we],Ne={__name:"ActionEdit",props:{link:Boolean,to:String},emits:["click"],setup(e){return(c,t)=>e.link?(s(),O(d(_),{key:0,onClick:t[0]||(t[0]=l=>c.$emit("click")),href:e.to,class:"hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full"},{default:v(()=>[xe]),_:1},8,["href"])):(s(),o("button",{key:1,onClick:t[1]||(t[1]=l=>c.$emit("click")),class:"hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full"},ke))}};export{je as _,Ne as a,Ce as b};
