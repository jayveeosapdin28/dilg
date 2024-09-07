import{_ as A}from"./AuthenticatedLayout-8DZWhUx3.js";import{m as _,j as f,r as w,o as m,g as B,a as n,u as s,w as l,F as N,Q as p,Z as U,b as e,c as d,d as D,f as c,t as v}from"./app-DDm3ur_q.js";import{_ as S}from"./DataTable-9lVUghE3.js";import{_ as F,a as R}from"./ActionEdit-DD3bpGmO.js";import{u as j}from"./useCrud-e9fVmAFn.js";import E from"./UserForm-C1y8EXJ3.js";import{_ as H}from"./PageHeading-DVYt6gRm.js";import{u as I}from"./useRole-CIxqukLy.js";import"./useConfirmMessage-C-IUxGMr.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./NavigationDrawer-DUxpNc25.js";const Q={class:"space-x-4"},T=e("i",{class:"bi bi-plus mr-1"},null,-1),Z={class:"overflow-y-auto"},q={class:"bg-white rounded-lg p-6"},z={class:"flex items-center gap-3"},G={class:"font-semibold text-sm"},J={class:"text-sm"},K={class:"flex justify-end items-center"},L="Users",le={__name:"Index",setup(M){const k=[{label:"Name",field:"name"},{label:"Role",field:"role"},{label:"Actions",field:"action",width:"5%"}],{hasRole:o}=I(),h=_(()=>p().props.users),b=_(()=>p().props.store_id),r=f(!1),u=f({}),x=a=>{u.value={...a},r.value=!0},{destroy:y}=j(),C=a=>{y(route("admin.users.destroy",a))},V=[{name:"Users",href:"#",current:!0}];return(a,i)=>{const $=w("VBtn");return m(),B(N,null,[n(s(U),{title:"User"}),n(E,{modelValue:r.value,"onUpdate:modelValue":i[0]||(i[0]=t=>r.value=t),"store-id":b.value,data:u.value},null,8,["modelValue","store-id","data"]),n(A,null,{default:l(()=>[n(H,{title:L,pages:V},{action:l(()=>[e("div",Q,[s(o)("Super Admin")||s(o)("Admin")?(m(),d($,{key:0,onClick:i[1]||(i[1]=t=>r.value=!0),variant:"outlined",color:"primary"},{default:l(()=>[T,D(" Create ")]),_:1})):c("",!0)])]),_:1}),e("div",Z,[e("div",q,[n(S,{class:"mb-12",columns:k,data:h.value,"filter-link":a.route("admin.users.index")},{column_name:l(({props:t})=>[e("div",z,[e("div",null,[e("p",G,v(t.name),1),e("span",J,v(t.email),1)])])]),column_action:l(({props:t})=>[e("div",K,[s(o)("Super Admin")||s(o)("Admin")?(m(),d(F,{key:0,onClick:g=>x(t)},null,8,["onClick"])):c("",!0),s(o)("Super Admin")||s(o)("Admin")?(m(),d(R,{key:1,onClick:g=>C(t.id)},null,8,["onClick"])):c("",!0)])]),_:1},8,["data","filter-link"])])])]),_:1})],64)}}};export{le as default};
