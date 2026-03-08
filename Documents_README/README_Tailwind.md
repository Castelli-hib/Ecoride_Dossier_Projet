
# Guide des classes Tailwind

- classe rounded-full est utilisée pour rendre les bords d’un élément complètement arrondis,
- un cercle ou une ellipse selon les dimensions de l’élément.
- Elle correspond à une valeur border-radius: 9999px; en CSS classique.

Voici le détail :

Classe Tailwind             CSS correspondant          Description
---------------------------|--------------------------|----------------------------------------
rounded-none                border-radius: 0;           Pas d’arrondi
rounded-sm                  border-radius: 0.125rem;    Petit arrondi
rounded                     border-radius: 0.25rem;     Arrondi standard
rounded-md                  border-radius: 0.375rem;    Arrondi moyen
rounded-lg                  border-radius: 0.5rem;      Arrondi large
rounded-xl                  border-radius: 0.75rem;c    Très grand arrondi
rounded-2xl                 border-radius: 1rem;        Encore plus grand
rounded-3xl                 border-radius: 1.5rem;      Très arrondi
rounded-full                border-radius: 9999px;      Complètement arrondi, parfait pour cercles
rounded-[value]             border-radius: value;       Valeur personnalisée avec brackets

Pour que rounded-full produise un cercle parfait, l’élément doit avoir la même largeur et hauteur (w-16 h-16 par exemple). Sinon, vous obtiendrez une ellipse.

## Homepage

Classe Tailwind                 CSS équivalent / Effet                            Description détaillée
------------------------------|-----------------------------------------------|----------------------------------------
bg-white/10                     background-color: rgba(255,255,255,0.1);        Fond blanc avec opacité 10%
hover:bg-white/20               background-color: rgba(255,255,255,0.2);        Au survol, fd blc passe à 20% d’opacité
backdrop-blur-md                backdrop-filter: blur(12px);                      Flou de l’arrière-plan derrière élment
text-white                      color: #ffffff;                                 Texte en blanc
border                          border-width: 1px;                                 Ajoute une bordure par défaut (1px)
border-white/30                 border-color: rgba(255,255,255,0.3);             Bordure blanche avec 30% d’opacité
px-8                            padding-left: 2rem; padding-right: 2rem;           Padding horizontal (gauche et droite)
py-4                            padding-top: 1rem; padding-bottom: 1rem;           Padding vertical (haut et bas)
rounded-[15px]                  border-radius: 15px;                               Bords arrondis avec rayon 15px
font-bold                       font-weight: 700;                                  Texte en gras
transition-all                  transition: all 0.2s ease-in-out                   Transition douce pour tous les changements (ex : hover)
text-lg                         font-size: 1.125rem; line-height: 1.75rem;          Taille de texte large
inline-block                    display: inline-block;                              Éléments en ligne mais pouvant avoir largeur/hauteur

## Layout & Display

Classe                      CSS équivalent              Notes / Responsive
---------------------------|--------------------------|----------------------------------------
block                       display: block;             sm:block, md:block, …
inline                      display: inline;
inline-block                display: inline-block;
flex                        display: flex;              sm:flex, md:flex, …
inline-flex                 display: inline-flex;
grid                        display: grid;
hidden                      display: none;              sm:hidden, md:hidden, …

container                   max-width: 100%;
                            margin-left:auto;
                            margin-right:auto;
                            Points breakpoints définis par Tailwind

**Sizing (Width / Height / Min / Max)**
Classe CSS équivalent Notes / Responsive
w-full width: 100%; sm:w-full
w-1/2 width: 50%;
h-screen height: 100vh;
min-h-full min-height: 100%;
max-w-xs max-width: 20rem;

**Spacing (Margin / Padding / Gap)**
Classe CSS équivalent Notes / Responsive
m-4 margin: 1rem; sm:m-4
mt-2 margin-top: 0.5rem;
mx-auto margin-left:auto; margin-right:auto;
p-6 padding: 1.5rem;
px-4 padding-left:1rem; padding-right:1rem;
py-2 padding-top:0.5rem; padding-bottom:0.5rem;
gap-4 gap:1rem; Pour flex/grid

**Typography**
Classe CSS équivalent Notes / Responsive
text-xs font-size: 0.75rem; line-height:1rem; sm:text-xs, md:text-sm
text-sm font-size: 0.875rem; line-height:1.25rem;
text-base font-size: 1rem; line-height:1.5rem;
text-lg font-size:1.125rem; line-height:1.75rem;
text-xl font-size:1.25rem; line-height:1.75rem;
font-thin font-weight:100;
font-light font-weight:300;
font-normal font-weight:400;
font-medium font-weight:500;
font-semibold font-weight:600;
font-bold font-weight:700;
text-left text-align:left; sm:text-center …
text-center text-align:center;
text-right text-align:right;
uppercase text-transform: uppercase;
lowercase text-transform: lowercase;
capitalize text-transform: capitalize;

**Backgrounds & Colors**
Classe CSS équivalent Notes / Responsive / State
bg-white background-color:#fff; hover:bg-white, sm:bg-white
bg-black background-color:#000;
bg-gray-100 background-color:#f3f4f6;
bg-red-500 background-color:#ef4444;
bg-gradient-to-r from-red-500 to-blue-500 background-image: linear-gradient(to right,#ef4444,#3b82f6);
bg-white/10 background-color: rgba(255,255,255,0.1); hover:bg-white/20

**Borders & Radius**
Classe CSS équivalent Notes / Responsive / State
border border-width:1px;
border-2 border-width:2px;
border-gray-300 border-color:#d1d5db;
border-white/30 border-color: rgba(255,255,255,0.3);
rounded-none border-radius:0;
rounded-sm border-radius:0.125rem;
rounded border-radius:0.25rem;
rounded-md border-radius:0.375rem;
rounded-lg border-radius:0.5rem;
rounded-xl border-radius:0.75rem;
rounded-2xl border-radius:1rem;
rounded-3xl border-radius:1.5rem;
rounded-full border-radius:9999px;
rounded-[15px] border-radius:15px;

**Flex & Grid**
Classe CSS équivalent Notes
flex display:flex; sm:flex …
inline-flex display:inline-flex;
flex-row flex-direction: row;
flex-col flex-direction: column;
items-start align-items: flex-start;
items-center align-items: center;
items-end align-items: flex-end;
justify-start justify-content:flex-start;
justify-center justify-content:center;
justify-end justify-content:flex-end;
justify-between justify-content:space-between;
gap-1 à gap-96 gap:0.25rem → 24rem;

**Effects (Shadow / Opacity / Blur / Transition)**
Classe CSS équivalent Notes
shadow box-shadow:0 1px 3px rgba(0,0,0,0.1),0 1px 2px rgba(0,0,0,0.06);
shadow-md box-shadow:0 4px 6px -1px rgba(0,0,0,0.1),0 2px 4px -1px rgba(0,0,0,0.06);
shadow-lg box-shadow:0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -2px rgba(0,0,0,0.05);
opacity-0 → opacity-100 opacity:0 → 1;
backdrop-blur backdrop-filter: blur(4px); backdrop-blur-md: 12px, backdrop-blur-lg:16px
transition transition-property:background-color,border-color,color,fill,stroke,opacity,box-shadow,transform; transition-duration:150ms; transition-timing-function:cubic-bezier(0.4,0,0.2,1);
transition-all transition-property: all; …

**States & Variants**
Classe CSS équivalent
hover:bg-gray-200 :hover { background-color:#e5e7eb; }
focus:outline-none :focus { outline:0; }
active:bg-blue-500 :active { background-color:#3b82f6; }
disabled:opacity-50 :disabled { opacity:0.5; }
sm:text-lg @media(min-width:640px){ font-size:… }
md:text-xl @media(min-width:768px){ font-size:… }
