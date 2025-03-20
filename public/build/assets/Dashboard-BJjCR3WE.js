import{o,f as i,b as s,i as w,q as b,k as f,p as x,F as p,s as _,t as c,a as h,w as m,u as g,P as v,g as u,l as M,c as $}from"./app-UflIzx5p.js";import{_ as I}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{A as z}from"./AuthenticatedLayout-C_T42wHi.js";/* empty css            */import"./ApplicationLogo-BEQ8lapF.js";const N={data(){return{query:""}},methods:{onSearch(){this.query.length>=3&&this.searchMovies(this.query)},async searchMovies(d){try{const[e,l]=await Promise.all([fetch(`https://api.themoviedb.org/3/search/movie?query=${encodeURIComponent(d)}`,{headers:{accept:"application/json",Authorization:"Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjMGQ1ZTJlNzUzMWY1MTRlMDI1YzIwNDQ3Y2I0N2Q3OCIsIm5iZiI6MTczNzQ1Nzg5OC42ODk5OTk4LCJzdWIiOiI2NzhmODBlYWY4N2Y0MTE5ZTZhYWFmNzkiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.2-txuO5P4dqyVq4il9ULMYMiHMRBD-8dXXD9HSQocUg"}}),fetch(`https://api.themoviedb.org/3/search/tv?query=${encodeURIComponent(d)}`,{headers:{accept:"application/json",Authorization:"Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjMGQ1ZTJlNzUzMWY1MTRlMDI1YzIwNDQ3Y2I0N2Q3OCIsIm5iZiI6MTczNzQ1Nzg5OC42ODk5OTk4LCJzdWIiOiI2NzhmODBlYWY4N2Y0MTE5ZTZhYWFmNzkiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.2-txuO5P4dqyVq4il9ULMYMiHMRBD-8dXXD9HSQocUg"}})]),a=await e.json(),r=await l.json();this.$emit("results-updated",{movies:a.results||[],tvShows:r.results||[]})}catch(e){console.error("Erreur lors de la recherche de films :",e),this.$emit("results-updated",[])}}}},k={class:"py-12"},Y={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},O={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},D={class:"p-6 text-gray-900"};function J(d,e,l,a,r,n){return o(),i("div",k,[s("div",Y,[s("div",O,[s("div",D,[w(s("input",{type:"text",class:"w-full px-4 py-2 border border-gray-300 rounded-md",placeholder:"Search...","onUpdate:modelValue":e[0]||(e[0]=t=>r.query=t),onInput:e[1]||(e[1]=(...t)=>n.onSearch&&n.onSearch(...t))},null,544),[[b,r.query]])])])])])}const y=I(N,[["render",J],["__scopeId","data-v-2f84bf0d"]]),S={class:"py-12"},T={class:"mx-auto max-w-7xl sm:px-6 lg:px-8"},Q={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg p-6"},U={key:0},X={class:"text-lg font-semibold mb-2"},B={key:0,class:"flex justify-center"},R=["src"],A={key:1,class:"text-gray-500"},C={key:1,class:"mt-6"},W=["src"],q={key:2,class:"text-gray-500"},V={__name:"UserList",props:{lists:Array},setup(d){const e=f([]),l=f([]);return x(async()=>{try{const r=await M.get(route("lists.index"));e.value=r.data.lists,l.value=r.data.sharedLists}catch(r){console.error("Erreur lors de la récupération des listes :",r)}}),(r,n)=>(o(),i("div",S,[s("div",T,[s("div",Q,[n[1]||(n[1]=s("h1",{class:"text-2xl font-bold mb-4"},"Vos listes",-1)),e.value.length>0?(o(),i("ul",U,[(o(!0),i(p,null,_(e.value,t=>(o(),i("li",{key:t.id,class:"border-b py-4 text-center"},[s("h2",X,c(t.name)+" ("+c(t.items.length)+")",1),t.items.length>0&&t.items[0].movie&&t.items[0].movie.poster_path?(o(),i("div",B,[h(g(v),{href:`/lists/${t.id}`},{default:m(()=>[s("img",{src:"https://image.tmdb.org/t/p/w500"+t.items[0].movie.poster_path,alt:"Affiche du film",class:"w-32 h-48 rounded-lg shadow"},null,8,R)]),_:2},1032,["href"])])):(o(),i("p",A,"Aucun film dans cette liste."))]))),128))])):u("",!0),l.value.length>0?(o(),i("div",C,[n[0]||(n[0]=s("h3",{class:"text-lg font-semibold mb-2"},"Listes Partagées avec Moi",-1)),s("ul",null,[(o(!0),i(p,null,_(l.value,t=>(o(),i("li",{key:t.list.id,class:"border-b py-2"},[h(g(v),{href:`/lists/${t.list.id}`},{default:m(()=>[t.list.items.length>0&&t.list.items[0].movie&&t.list.items[0].movie.poster_path?(o(),i("img",{key:0,src:"https://image.tmdb.org/t/p/w500"+t.list.items[0].movie.poster_path,alt:"Affiche du film",class:"w-32 h-48 rounded-lg shadow"},null,8,W)):u("",!0),s("span",null,c(t.list.name),1)]),_:2},1032,["href"])]))),128))])])):u("",!0),e.value.length===0&&l.value.length===0?(o(),i("p",q,"Aucune liste trouvée.")):u("",!0)])])]))}},Z={class:"py-12"},j={class:"mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-4 gap-6"},L={class:"lg:col-span-3"},P={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg"},E={class:"p-6 text-gray-900"},F={key:0,class:"mt-4 p-6"},G={class:"grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"},H=["src"],K={class:"p-4"},ss={class:"font-semibold text-center"},es={class:"text-sm text-gray-600 text-center"},ts={key:1,class:"mt-8 p-6"},os={class:"grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"},is=["src"],ls={class:"p-4"},rs={class:"font-semibold text-center"},as={class:"text-sm text-gray-600 text-center"},ds={class:"lg:col-span-1"},ns={class:"overflow-hidden bg-white shadow-sm sm:rounded-lg p-6"},cs={components:{SearchBar:y},data(){return{movies:[],tvShows:[]}},methods:{updateResults({movies:d,tvShows:e}){this.movies=d,this.tvShows=e}}},gs=Object.assign(cs,{__name:"Dashboard",setup(d){return(e,l)=>(o(),$(z,null,{header:m(()=>l[0]||(l[0]=[s("h2",{class:"text-xl font-semibold leading-tight text-gray-800"}," Dashboard ",-1)])),default:m(()=>[s("div",Z,[s("div",j,[s("div",L,[s("div",P,[s("div",E,[h(y,{onResultsUpdated:e.updateResults},null,8,["onResultsUpdated"])]),e.movies&&e.movies.length>0?(o(),i("div",F,[l[1]||(l[1]=s("h2",{class:"text-lg font-bold mb-4"},"Movies:",-1)),s("div",G,[(o(!0),i(p,null,_(e.movies,(a,r)=>(o(),i("div",{key:r,class:"border border-gray-300 rounded-md shadow-sm overflow-hidden"},[h(g(v),{href:e.route("tv.details",{id:a.id,type:"movie"})},{default:m(()=>[s("img",{src:`https://image.tmdb.org/t/p/w200${a.poster_path}`,alt:"Movie Poster",class:"w-full h-auto"},null,8,H)]),_:2},1032,["href"]),s("div",K,[s("h3",ss,c(a.title),1),s("p",es," Release Date: "+c(a.release_date||"N/A"),1)])]))),128))])])):u("",!0),e.tvShows&&e.tvShows.length>0?(o(),i("div",ts,[l[2]||(l[2]=s("h2",{class:"text-lg font-bold mb-4"},"TV Shows:",-1)),s("div",os,[(o(!0),i(p,null,_(e.tvShows,(a,r)=>(o(),i("div",{key:r,class:"border border-gray-300 rounded-md shadow-sm overflow-hidden"},[h(g(v),{href:e.route("tv.details",{id:a.id,type:"tv"})},{default:m(()=>[s("img",{src:`https://image.tmdb.org/t/p/w200${a.poster_path}`,alt:"TV Show Poster",class:"w-full h-auto"},null,8,is)]),_:2},1032,["href"]),s("div",ls,[s("h3",rs,c(a.name),1),s("p",as," First Air Date: "+c(a.first_air_date||"N/A"),1)])]))),128))])])):u("",!0)])]),s("div",ds,[s("div",ns,[h(V)])])])])]),_:1}))}});export{gs as default};
