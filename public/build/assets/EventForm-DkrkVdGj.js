import{m as d,T as N,q as g,j as k,k as T,r as f,o as j,g as q,a as s,u as r,w as i,F as z,Q as c,b as u,t as $,d as E,D as S}from"./app-C9HRCpWf.js";import{u as L}from"./useCrud-BWhZUWAg.js";import{L as M,N as I}from"./NavigationDrawer-B4OZeLQU.js";import{E as O}from"./Editor-DvQm7HV9.js";import"./useConfirmMessage-BgYMZEU1.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./InputLabel-vCFBHihW.js";const P={class:"font-semibold text-lg"},Q={class:"md:grid grid-cols-2 gap-4"},A={class:"md:grid grid-cols-2 gap-4"},G={class:"md:grid grid-cols-2 gap-4"},H={class:"flex gap-4 justify-end"},h={__name:"EventForm",props:{modelValue:[Boolean,String],storeId:[String,Number],data:Object},emits:["update:modelValue","close","on-success"],setup(U,{emit:x}){const o=U,y=x,C=d(()=>c().props.cities),w=d(()=>c().props.provinces),_=d(()=>c().props.barangays),m=d(()=>c().props.request);let e=N({id:null,event_name:o.event_name,description:o.description,date_open:o.date_open,date_close:o.date_close,status:o.status,state:o.state,city:o.city,street:o.street,barangay:o.barangay});g(()=>o.data,l=>{e.id=l.id??null,e.event_name=l.event_name??null,e.description=l.description??null,e.date_open=l.date_open??null,e.date_closed=l.date_closed??null,e.status=l.status??null});const p=k({city:null,state:null,barangay:null});g(()=>e.state,l=>{p.value.state=l,l||(e.city=null),S.get(route("admin.events.index"),p.value,{preserveState:!0,preserveScroll:!0})}),g(()=>e.city,l=>{p.value.city=l,l||(e.barangay=null),S.get(route("admin.events.index"),p.value,{preserveState:!0,preserveScroll:!0})});const n=d({set:l=>{y("update:modelValue",l)},get:()=>o.modelValue}),{submitForm:F}=L(),B=async()=>{await F(e,`admin.events.${e.id?"update":"store"}`,null,!0,!0).then(l=>{y("on-success"),e.reset(),n.value=!1})},D=()=>{e.reset(),y("close")};return g(()=>n.value,()=>{n.value||e.reset()}),T(()=>{m.value.city&&!e.state&&(e.city=m.value.city),m.value.state&&!e.state&&(e.state=m.value.state)}),(l,t)=>{const v=f("VTextField"),b=f("VSelect"),V=f("VBtn");return j(),q(z,null,[s(M,{show:r(e).processing},null,8,["show"]),s(I,{class:"z-50",onClose:D,modelValue:n.value,"onUpdate:modelValue":t[18]||(t[18]=a=>n.value=a),size:"400",width:"60"},{header:i(()=>[u("p",P,$(`${r(e).id?"Update":"Create"} Event`),1)]),default:i(()=>[s(v,{color:"primary",label:"Name",variant:"outlined",density:"comfortable",modelValue:r(e).event_name,"onUpdate:modelValue":[t[0]||(t[0]=a=>r(e).event_name=a),t[1]||(t[1]=a=>r(e).clearErrors("event_name"))],"error-messages":r(e).errors.event_name},null,8,["modelValue","error-messages"]),u("div",Q,[s(v,{color:"primary",label:"Date From",variant:"outlined",type:"date",density:"comfortable",modelValue:r(e).date_open,"onUpdate:modelValue":[t[2]||(t[2]=a=>r(e).date_open=a),t[3]||(t[3]=a=>r(e).clearErrors("date_open"))],"error-messages":r(e).errors.date_open},null,8,["modelValue","error-messages"]),s(v,{color:"primary",label:"Date To",type:"date",variant:"outlined",density:"comfortable",modelValue:r(e).date_close,"onUpdate:modelValue":[t[4]||(t[4]=a=>r(e).date_close=a),t[5]||(t[5]=a=>r(e).clearErrors("date_close"))],"error-messages":r(e).errors.date_close},null,8,["modelValue","error-messages"])]),u("div",A,[s(b,{clearable:"",color:"primary",label:"Province",variant:"outlined",density:"comfortable",items:w.value,"item-title":"label","item-value":"value",modelValue:r(e).state,"onUpdate:modelValue":[t[6]||(t[6]=a=>r(e).state=a),t[7]||(t[7]=a=>r(e).clearErrors("state"))],"error-messages":r(e).errors.state},null,8,["items","modelValue","error-messages"]),s(b,{clearable:"",disabled:!C.value.length,color:"primary",label:"City / Municipality",variant:"outlined",density:"comfortable",items:C.value,"item-title":"label","item-value":"value",modelValue:r(e).city,"onUpdate:modelValue":[t[8]||(t[8]=a=>r(e).city=a),t[9]||(t[9]=a=>r(e).clearErrors("city"))],"error-messages":r(e).errors.city},null,8,["disabled","items","modelValue","error-messages"])]),u("div",G,[s(b,{clearable:"",disabled:!_.value.length,color:"primary",label:"Barangay",variant:"outlined",density:"comfortable",items:_.value,"item-title":"label","item-value":"value",modelValue:r(e).barangay,"onUpdate:modelValue":[t[10]||(t[10]=a=>r(e).barangay=a),t[11]||(t[11]=a=>r(e).clearErrors("barangay"))],"error-messages":r(e).errors.barangay},null,8,["disabled","items","modelValue","error-messages"]),s(v,{color:"primary",label:"Street",variant:"outlined",density:"comfortable",modelValue:r(e).street,"onUpdate:modelValue":[t[12]||(t[12]=a=>r(e).street=a),t[13]||(t[13]=a=>r(e).clearErrors("street"))],"error-messages":r(e).errors.street},null,8,["modelValue","error-messages"])]),s(O,{label:"Details",modelValue:r(e).description,"onUpdate:modelValue":[t[14]||(t[14]=a=>r(e).description=a),t[15]||(t[15]=a=>r(e).clearErrors("description"))],"error-messages":r(e).errors.description},null,8,["modelValue","error-messages"])]),footer:i(()=>[u("div",H,[s(V,{color:"error",onClick:t[16]||(t[16]=a=>n.value=!1)},{default:i(()=>[E(" Close ")]),_:1}),s(V,{onClick:t[17]||(t[17]=a=>r(e).reset())},{default:i(()=>[E(" Clear Fields ")]),_:1}),s(V,{variant:"flat",color:"primary",onClick:B},{default:i(()=>[E($(r(e).id?"Update":"Submit"),1)]),_:1})])]),_:1},8,["modelValue"])],64)}}};export{h as default};
