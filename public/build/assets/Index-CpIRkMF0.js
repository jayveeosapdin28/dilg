import{_ as F}from"./AuthenticatedLayout-B6CBpUQ4.js";import{r as w,o as c,c as x,w as s,d as p,t as v,j as f,m as h,k as N,g,a as e,u as i,F as y,Q as C,Z as j,b as o,f as b,i as P}from"./app-wyvEKVqs.js";import{_ as R}from"./DataTable-BJUNLuNB.js";import{_ as U,a as z}from"./ActionEdit-B7CWK-IN.js";import{u as E}from"./useCrud-BtqAZ-RU.js";import H from"./TaskForm-BYURw5WS.js";import{_ as I}from"./StatusBadge-DIGoGGvf.js";import{_ as L}from"./PageHeading-DSNQyjkU.js";import{u as M}from"./useRole-gy2WcH5o.js";import{_ as Q}from"./ActionView-DS7v020M.js";import{u as Z}from"./useFormat-gSL8o3NQ.js";import"./useConfirmMessage-CbbOum34.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./lodash-Dhc7DghO.js";import"./NavigationDrawer-Acetu_ha.js";import"./filepond-plugin-image-preview.esm-CI_uTiYr.js";import"./Editor-DQUihYYJ.js";import"./InputLabel-C0PUCVx6.js";import"./dayjs.min-CkXyQpRJ.js";const q={__name:"PriorityBadge",props:{status:String},setup(d){const n=l=>({low:"info",medium:"warning",high:"error"})[l.toLowerCase().replace(/\s+/g,"_")];return(l,r)=>{const _=w("VChip");return c(),x(_,{size:"small",color:n(d.status),variant:"tonal"},{default:s(()=>[p(v(d.status.toUpperCase()),1)]),_:1},8,["color"])}}},G={class:"space-x-4"},J=o("i",{class:"bi bi-plus mr-1"},null,-1),K={class:"overflow-y-auto"},O={class:"bg-white rounded-lg p-6"},W={class:"flex items-center gap-3"},X={class:"font-semibold text-sm hover:text-primary-600 hover:underline"},Y={class:"flex items-center justify-center gap-3"},tt={class:"flex items-center justify-center gap-3"},et={class:"flex justify-end items-center"},st="Tasks",bt={__name:"Index",setup(d){const{hasRole:n}=M(),{date:l}=Z(),r=f([{label:"Name",field:"name"},{label:"Status",field:"status",align:"center"},{label:"Priority",field:"priority",align:"center"},{label:"Submitted Documents",field:"documents_count"},{label:"Comment",field:"comments"},{label:"Due Date",field:"due_date"},{label:"Actions",field:"action",width:"5%"}]),_=h(()=>C().props.tasks),V=h(()=>C().props.store_id),m=f(!1),k=f({}),$=a=>{k.value={...a},m.value=!0},{destroy:A}=E(),B=a=>{A(route("admin.tasks.destroy",a))},D=[{name:"Tasks",href:"#",current:!0}];return N(()=>{(n("Super Admin")||n("Admin"))&&(r.value=r.value.filter(a=>a.field!=="status"))}),(a,u)=>{const S=w("VBtn");return c(),g(y,null,[e(i(j),{title:"Task"}),e(H,{modelValue:m.value,"onUpdate:modelValue":u[0]||(u[0]=t=>m.value=t),"store-id":V.value,data:k.value},null,8,["modelValue","store-id","data"]),e(F,null,{default:s(()=>[e(L,{title:st,pages:D},{action:s(()=>[o("div",G,[i(n)("Super Admin")||i(n)("Admin")?(c(),x(S,{key:0,onClick:u[1]||(u[1]=t=>m.value=!0),variant:"outlined",color:"primary"},{default:s(()=>[J,p(" Create ")]),_:1})):b("",!0)])]),_:1}),o("div",K,[o("div",O,[e(R,{class:"mb-12",columns:r.value,data:_.value,"filter-link":a.route("admin.tasks.index")},{column_name:s(({props:t})=>[o("div",W,[e(i(P),{href:a.route("admin.tasks.show",t.id)},{default:s(()=>[o("p",X,v(t.name),1)]),_:2},1032,["href"])])]),column_priority:s(({props:t})=>[o("div",Y,[e(q,{status:t.priority},null,8,["status"])])]),column_status:s(({props:t})=>[o("div",tt,[e(I,{status:t.status},null,8,["status"])])]),column_due_date:s(({props:t})=>[p(v(i(l)(t.due_date)),1)]),column_action:s(({props:t})=>[o("div",et,[e(Q,{link:"",href:a.route("admin.tasks.show",t.id)},null,8,["href"]),i(n)("Super Admin")||i(n)("Admin")?(c(),g(y,{key:0},[e(U,{onClick:T=>$(t)},null,8,["onClick"]),e(z,{onClick:T=>B(t.id)},null,8,["onClick"])],64)):b("",!0)])]),_:1},8,["columns","data","filter-link"])])])]),_:1})],64)}}};export{bt as default};
