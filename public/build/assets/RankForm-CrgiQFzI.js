import{T as _,l as p,h as w,r as c,o as F,g as N,a as n,u as o,w as r,F as y,b as f,t as V,d as i}from"./app-D5M1G0zN.js";import{L as B,N as $,u as S}from"./NavigationDrawer-BRZQ9b0p.js";import"./useConfirmMessage-MezlQya-.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const T={class:"font-semibold text-lg"},U={class:"flex gap-4 justify-end"},I={__name:"RankForm",props:{modelValue:[Boolean,String],storeId:[String,Number],data:Object},emits:["update:modelValue","close","on-success"],setup(g,{emit:v}){const u=g,d=v;let e=_({id:null,name:u.storeId});p(()=>u.data,s=>{e.id=s.id??null,e.name=s.name??null});const a=w({set:s=>{d("update:modelValue",s)},get:()=>u.modelValue}),{submitForm:C}=S(),b=async()=>{await C(e,`admin.ranks.${e.id?"update":"store"}`,null,!0,!0).then(s=>{d("on-success"),e.reset(),a.value=!1})},k=()=>{e.reset(),d("close")};return p(()=>a.value,()=>{a.value||e.reset()}),(s,t)=>{const x=c("VTextField"),m=c("VBtn");return F(),N(y,null,[n(B,{show:o(e).processing},null,8,["show"]),n($,{class:"z-50",onClose:k,modelValue:a.value,"onUpdate:modelValue":t[4]||(t[4]=l=>a.value=l),size:"400"},{header:r(()=>[f("p",T,V(`${o(e).id?"Update":"Create"} Rank`),1)]),default:r(()=>[n(x,{color:"primary",label:"Name",variant:"outlined",density:"comfortable",modelValue:o(e).name,"onUpdate:modelValue":[t[0]||(t[0]=l=>o(e).name=l),t[1]||(t[1]=l=>o(e).clearErrors("name"))],"error-messages":o(e).errors.name},null,8,["modelValue","error-messages"])]),footer:r(()=>[f("div",U,[n(m,{color:"error",onClick:t[2]||(t[2]=l=>a.value=!1)},{default:r(()=>[i(" Close ")]),_:1}),n(m,{onClick:t[3]||(t[3]=l=>o(e).reset())},{default:r(()=>[i(" Clear Fields ")]),_:1}),n(m,{variant:"flat",color:"primary",onClick:b},{default:r(()=>[i(V(o(e).id?"Update":"Submit"),1)]),_:1})])]),_:1},8,["modelValue"])],64)}}};export{I as default};
