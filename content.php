<div class="container">
    <h1>Načítavanie faktúr elektronicky</h1>
    <p>QR Faktúra umožňuje načítanie niektorých údajov z faktúry pomocou QR kódu</p>

    <hr/>
    <br/>

    <h2 id="Uvod">Pár slov na úvod</h2>
    <p>Tento projekt vznikol z jednoduchého dôvodu. Nesúhlasíme, aby slovenský štandard využíval spoplatené knihovne/služby ako to bolo v prípade QR kódu na platbu. Chceme, aby bol QR kód jednoduchý, prehľadný, ľahko použiteľný a zadarmo pre každého.</p>
    <p>Špecifikácia je silne inšpirovaná z ČR a to z dôvodu, aby nebolo pre firmy veľmi nákladné generovanie kódov zapracovať. Veľa účtovného softvéru z ČR sa používa aj u nás na Slovensku.</p>
    <p>Čím viac firiem bude podporovať túto špecifikáciu, tým skôr docielime aby sa z QR Faktúry stal štandard.</p>
    <p>Používanie QR Faktúry nepodlieha z našej strany žiadnym licenčným podmienkam, ani povinnej registrácie. Zdrojové kódy tejto stránky sú verejne dostupné na <a href="https://github.com/owlysoft/qr-faktura-sk" target="_blank" class="contrast" >GitHube</a>.</p>

    <article>
        <header>Upozornenie</header>
        Nejedná sa o popis formátu pre <b>INVOICE by Square</b>!
    </article>

    <hr/>
    <br/>

    <h2 id="PopisFormatu">Popis formátu</h2>
    <div>
        <p>Reťazec QR kódu pre QR faktúru môže obsahovať ľubovoľné znaky zo znakovej sady UTF-8.<br/>
        Doporučené znaky v reťazci sú:</p>
        <ul>
            <li>0-9</li>
            <li>A-Z</li>
            <li>medzera</li>
            <li>$, %, *, +, -, ., /, :</li>
        </ul>
        <p>
            Reťazec vždy začína <code>SQF*</code>. Nasledne je uvedená verzia protokolu (dve čísla oddelené bodkou) ukončná hviezdičkou - napr. <code>1.0*</code> . Spolu teda <code>SQF*1.0*...</code>
            <br/>
            Nasledujú jednotlivé atribúty a ich hodnoty podľa kľúča <code>$(kľúč):(hodnota)*</code>.
            <br/>
            Kľúč je od hodnoty oddelený dvojbodkou a hodnota je ukončená hviezdičkou. Hvieždička v hodnote je zakódovaná ako <code>%2A</code>.
            <br/>
            Každý kľúč musí mať uvedenú nejakú hodnotu. Ak hodnotu nechceme generovať, nebudeme kľúč vôbec uvádzať.
        </p>
        <p>Jednotlivé kľúče a hodnoty sú uvedené v tabuľke nižšie:</p>
    </div>
    <table role="grid">
        <tr>
            <th>Kľúč</th>
            <th>Povinný</th>
            <th>Dĺžka</th>
            <th>Formát</th>
            <th>Popis</th>
            <th>Príklad</th>
        </tr>
        <tr>
            <td>ID</td>
            <td>✅</td>
            <td>max 40</td>
            <td>Všetky znaky z povolenej množiny okrem <code>*</code></td>
            <td>Jednoznačný identifikátor dokladu</td>
            <td>ID:ABCD123456789EF*</td>
        </tr>
        <tr>
            <td>DD</td>
            <td>✅</td>
            <td>8</td>
            <td>ISO 8601, dátum vo formate <code>YYYYMMDD</code>, iba numerické znaky</td>
            <td>Dátum vystavenia dokladu</td>
            <td>DD:20240101*</td>
        </tr>
        <tr>
            <td>AM</td>
            <td>✅</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Celková čiastka k úhrade v danej mene (viď kľúč <code>CC</code>). Kladná hodnota bez znamienka, záporná hodnota so znamienkom mínus.</td>
            <td>AM:123.45*</td>
        </tr>
        <tr>
            <td>CC</td>
            <td>-</td>
            <td>3</td>
            <td>ISO 4217, 3 znaky, veľké písmená</td>
            <td>Mena, ak nie je uvedené = EUR</td>
            <td>CC:EUR*</td>
        </tr>
        <tr>
            <td>TP</td>
            <td>-</td>
            <td>1</td>
            <td>číslo</td>
            <td>
                Typ daňového plnenia
                <ul>
                    <li>0 alebo neuvedené = bežný typ</li>
                    <li>1 = RDPD</li>
                </ul>
            </td>
            <td>TP:0*</td>
        </tr>
        <tr>
            <td>TD</td>
            <td>-</td>
            <td>1</td>
            <td>číslo</td>
            <td>
                Identifikácia typu dokladu:
                <ul>
                    <li>0 = nedaňový doklad</li>
                    <li>1 = opravný doklad</li>
                    <li>2 = doklad k prijatej platbe</li>
                    <li>3 = splátkový kalendár</li>
                    <li>4 = platobný kalendár</li>
                    <li>5 = súhrnný daňový doklad</li>
                    <li>9 alebo neuvedené = ostatné daňové doklady</li>
                </ul>
            </td>
            <td>TD:9*</td>
        </tr>
        <tr>
            <td>SA</td>
            <td>-</td>
            <td>1</td>
            <td>číslo</td>
            <td>
                Príznak, či faktúra obsahuje zúčtovanie záloh
                <ul>
                    <li>0 alebo neuvedené = neobsahuje</li>
                    <li>1 = obsahuje</li>
                </ul>
            </td>
            <td>SA:0*</td>
        </tr>
        <tr>
            <td>MSG</td>
            <td>-</td>
            <td>max 40</td>
            <td>Všetky znaky z povolenej množiny okrem *</td>
            <td>Textový popis fakturácie</td>
            <td>MSG:KONZULTACIA 01/2024*</td>
        </tr>
        <tr>
            <td>ON</td>
            <td>-</td>
            <td>max 20</td>
            <td>Všetky znaky z povolenej množiny okrem *</td>
            <td>Číslo objednávky</td>
            <td>ON:OBJ2024001*</td>
        </tr>
        <tr>
            <td>VS</td>
            <td>-</td>
            <td>max 10</td>
            <td>Alfanumerický reťazec</td>
            <td>Variabilný symbol</td>
            <td>VS:1234*</td>
        </tr>
        <tr>
            <td>VII</td>
            <td>-</td>
            <td>max 14</td>
            <td>Alfanumerický reťazec</td>
            <td>DIČ vystavovateľa</td>
            <td>VII:202*</td>
        </tr>
        <tr>
            <td>IDI</td>
            <td>-</td>
            <td>max 14</td>
            <td>Alfanumerický reťazec</td>
            <td>IČ DPH vystavovateľa</td>
            <td>IDI:SK202*</td>
        </tr>
        <tr>
            <td>INI</td>
            <td>-</td>
            <td>max 8</td>
            <td>Číslo</td>
            <td>IČO vystavovateľa</td>
            <td>INI:12345678*</td>
        </tr>
        <tr>
            <td>VIR</td>
            <td>-</td>
            <td>max 14</td>
            <td>Alfanumerický reťazec</td>
            <td>DIČ príjemcu</td>
            <td>VIR:202*</td>
        </tr>
        <tr>
            <td>IDR</td>
            <td>-</td>
            <td>max 14</td>
            <td>Alfanumerický reťazec</td>
            <td>IČ DPH príjemcu</td>
            <td>IDR:SK202*</td>
        </tr>
        <tr>
            <td>INR</td>
            <td>-</td>
            <td>max 8</td>
            <td>Číslo</td>
            <td>IČO príjemcu</td>
            <td>INR:12345678*</td>
        </tr>
        <tr>
            <td>DUZP</td>
            <td>-</td>
            <td>8</td>
            <td>ISO 8601, dátum vo formate <code>YYYYMMDD</code>, iba numerické znaky</td>
            <td>Dátum uskutočnenia zdaniteľného plnenia</td>
            <td>DUZP:20240101*</td>
        </tr>
        <tr>
            <td>DT</td>
            <td>-</td>
            <td>8</td>
            <td>ISO 8601, dátum vo formate <code>YYYYMMDD</code>, iba numerické znaky</td>
            <td>dátum splatnosti celkovej čiastky</td>
            <td>DT:20240101*</td>
        </tr>
        <tr>
            <td>TB0</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Čiastka základu dane v základnej daňovej sadzbe. V prípade kladnej hodnoty uvádzame čiastku bez znamienka, v prípade zápornej uvádzame čiastku so znamienkom mínus.</td>
            <td>TB0:100*</td>
        </tr>
        <tr>
            <td>TB1</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Čiastka základu dane v 1. zníženej daňovej sadzbe. V prípade kladnej hodnoty uvádzame čiastku bez znamienka, v prípade zápornej uvádzame čiastku so znamienkom mínus.</td>
            <td>TB1:15*</td>
        </tr>
        <tr>
            <td>TB2</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Čiastka základu dane v 2. zníženej daňovej sadzbe. V prípade kladnej hodnoty uvádzame čiastku bez znamienka, v prípade zápornej uvádzame čiastku so znamienkom mínus.</td>
            <td>TB2:10*</td>
        </tr>
        <tr>
            <td>T0</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Čiastka dane v základnej daňovej sadzbe</td>
            <td>T0:12*</td>
        </tr>
        <tr>
            <td>T1</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Čiastka dane v 1. zníženej daňovej sadzbe</td>
            <td>T1:15*</td>
        </tr>
        <tr>
            <td>T2</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Čiastka dane v 2. zníženej daňovej sadzbe</td>
            <td>T2:10*</td>
        </tr>
        <tr>
            <td>NTB</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>čiastka oslobodená od plnenia, plnenie mimo DPH. V prípade kladnej hodnoty uvádzame čiastku bez znamienka, v prípade zápornej uvádzame čiastku so znamienkom mínus.</td>
            <td>NTB:200*</td>
        </tr>
        <tr>
            <td>FX</td>
            <td>-</td>
            <td>max 18</td>
            <td>Desatinné číslo, max. 2 des. miesta, <b>bodka</b> ako oddelovač des. miest</td>
            <td>Menný kurz medzi EUR a menou celkovej čiastky</td>
            <td>FX:123,45*</td>
        </tr>
        <tr>
            <td>FXA</td>
            <td>-</td>
            <td>max 5</td>
            <td>celé číslo</td>
            <td>Počet jednotiek cudzej meny pre prepočet pomocou kľúča <code>FX</code>. Ak nie je uvedené, FXA=1</td>
            <td>FXA:100*</td>
        </tr>
        <tr>
            <td>ACC</td>
            <td>-</td>
            <td>max 48</td>
            <td>Alfanumerický reťazec</td>
            <td>IBAN vystavovateľa</td>
            <td>ACC:SK4381800000007000001494*</td>
        </tr>
    </table>

    <div>
        <h2 id="Priklad">Príklad</h2>
        <table>
            <tr>
                <th>Obsah kódu</th>
                <th class="text-center">QR Faktúra</th>
            </tr>
            <tr>
                <td>
                    <code>SQF*1.0*ID:2024001*DD:20240101*AM:123.45*MSG:KONZULTACIA 01/2024*</code>
                </td>
                <td class="text-center">
                    <img src="api/?ID=2024001&DD=20240101&AM=123.45&MSG=KONZULTACIA%2001/2024" loading="lazy" class="qrinvoice_preview" alt="Príklad QR kódu" />
                </td>
            </tr>
        </table>
    </div>

    <div>
        <h2 id="PopisQRKodu">Popis QR kódu</h2>
        <p>Pod QR kódom sa nachádza text <code>QR-Faktúra</code>. Text má veľkosť 16px a používa font <code>Ubuntu Regular</code>.</p>
    </div>

    <br/>
    <hr/>
    <br/>

    <div>
        <h2 id="API">API</h2>
        <p>
            Pre vývojárov sme pripravili jednoduché API, ktoré vráti QR kód na faktúru.
            <br/>
            Volanie API je na adrese <code>https://qr-faktura.sk/api/?$kľúč=(hodnota)</code>, pričom do GET parametrov je možné vložiť kľúče z popisu formátu.<br/>
            Napr.: <code>https://qr-faktura.sk/api/?ID=2024001&DD=20240101&AM=123.45&MSG=KONZULTACIA%2001/2024</code>
            <p>API údaje neukladá. Dáta príjme, spracuje a zabudne.</p>
        </p>
    </div>

    <br/>
    <hr/>
    <br/>

    <div>
        <h2 id="Podpora">Podpora QR-Faktúry</h2>
        <p>
            Ak ste pre svoj softvér implementovali QR-Faktúru, dajte nám vedieť. Radi Vašu firmu uverejníme ako podporovateľa.
        </p>
    </div>

    <br/>
    <hr/>
    <br/>

    <div>
        <h2 id="Kontakt">Kontakt</h2>
        <p>
            V prípade otázok nás kontaktujte na emailovej adrese <a href="mailto:info@qr-faktura.sk" class="contrast" >info@qr-faktura.sk</a>
        </p>
    </div>
    <br/>
</div>