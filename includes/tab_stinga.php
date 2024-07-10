<?php
include "config.php";
include "functie.php";
?>
<?php renderList($nestedItems); ?>

<ul id="principal-list" class="tree">
    <li>
        <details>
            <summary>
                <input type="checkbox" id="BL"><span>BL</span>
            </summary>
            <ul>
                <li>
                    <details>
                        <summary>
                            <input type="checkbox" id="BL330"><span>BALTI330</span>
                        </summary>
                        <ul>
                            <li>
                                <details>
                                    <summary>
                                        <input type="checkbox" id="F2"><span>F2</span>
                                    </summary>
                                    <ul>
                                        <li>
                                            <details>
                                                <summary>
                                                    <input type="checkbox" id="PD26"><span>PD26</span>
                                                </summary>
                                                <ul>
                                                    <li>
                                                        <details>
                                                            <summary>
                                                                <input type="checkbox" id="F2"><span>F2</span>
                                                            </summary>
                                                            <ul>
                                                                <li>
                                                                    <details>
                                                                        <summary>
                                                                            <input type="checkbox" id="S1BL2"><span>S1BL2</span>
                                                                        </summary>
                                                                        <ul>
                                                                            <li><input type="checkbox" id="PT1"><span>PT1</span>
                                                                            </li>
                                                                            <li><input type="checkbox" id="PT2"><span>PT2</span>
                                                                            </li>
                                                                            <li><input type="checkbox" id="PT3"><span>PT3</span>
                                                                            </li>
                                                                        </ul>
                                                                    </details>
                                                                </li>
                                                            </ul>
                                                        </details>
                                                    <li>
                                                        <details>
                                                            <summary>
                                                                <input type="checkbox" id="F3"><span>F3</span>
                                                            </summary>
                                                            <ul>
                                                                <li><input type="checkbox" id="PT112"><span>PT112</span>
                                                                </li>
                                                                <li>
                                                                    <details>
                                                                        <summary>
                                                                            <input type="checkbox" id="2"><span>S11BL3</span>
                                                                        </summary>
                                                                        <ul>
                                                                            <li><input type="checkbox" id="PT11"><span>PT11</span>
                                                                            </li>
                                                                            <li><input type="checkbox" id="PT211"><span>PT211</span>
                                                                            </li>
                                                                            <li><input type="checkbox" id="PT311"><span>PT311</span>
                                                                            </li>
                                                                        </ul>
                                                                    </details>
                                                                </li>
                                                                <li><input type="checkbox" id="PT113"><span>PT113</span>
                                                                </li>
                                                            </ul>
                                                        </details>
                                                    </li>
                                                    </li>
                                                </ul>
                                            </details>
                                        </li>
                                    </ul>
                                </details>
                            </li>

                            <li>
                                <details>
                                    <summary>
                                        <input type="checkbox" id="4"><span>4</span>
                                    </summary>
                                    <ul>
                                        <li><input type="checkbox" id="PT4"><span>PT4</span></li>
                                        <li><input type="checkbox" id="PT5"><span>PT5</span></li>
                                        <li><input type="checkbox" id="PT6"><span>PT6</span></li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </details>
                <li>
                    <details>
                        <summary>
                            <input type="checkbox" id="cetnord"><span>CET Nord</span>
                        </summary>
                        <ul>
                            <li>
                                <details>
                                    <summary>
                                        <input type="checkbox" id="5"><span>5</span>
                                    </summary>
                                    <ul>
                                        <li><input type="checkbox" id="PT7"><span>PT7</span></li>
                                        <li><input type="checkbox" id="PT8"><span>PT8</span></li>
                                        <li><input type="checkbox" id="PT9"><span>PT9</span></li>
                                    </ul>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>
                                        <input type="checkbox" id="6"><span>6</span>
                                    </summary>
                                    <ul>
                                        <li><input type="checkbox" id="PT10"><span>PT10</span></li>
                                        <li><input type="checkbox" id="PT11"><span>PT11</span></li>
                                        <li><input type="checkbox" id="PT12"><span>PT12</span></li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary>
                            <input type="checkbox" id="raut"><span>Raut</span>
                        </summary>
                        <ul>
                            <li>
                                <details>
                                    <summary>
                                        <input type="checkbox" id="7"><span>7</span>
                                    </summary>
                                    <ul>
                                        <li><input type="checkbox" id="PT13"><span>PT13</span></li>
                                        <li><input type="checkbox" id="PT14"><span>PT14</span></li>
                                        <li><input type="checkbox" id="PT15"><span>PT15</span></li>
                                    </ul>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>
                                        <input type="checkbox" id="8"><span>8</span>
                                    </summary>
                                    <ul>
                                        <li><input type="checkbox" id="PT16"><span>PT16</span></li>
                                        <li><input type="checkbox" id="PT17"><span>PT17</span></li>
                                        <li><input type="checkbox" id="PT18"><span>PT18</span></li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </details>
                </li>

                </li>
            </ul>
        </details>
    </li>


    <li>
        <details>
            <summary><input type="checkbox" id="Subelement FR"><span>FR</span></summary>
            <ul>
                <li>
                    <details>
                        <summary><input type="checkbox" id="Subelement 1.2.1"><span>1.2.1</span></summary>
                        <ul>
                            <li><input type="checkbox" id="Subelement 1.2.1.1"><span>1.2.1.1</span></li>
                            <li>
                                <details>
                                    <summary><input type="checkbox" id="Subelement 1.2.1.2"><span>1.2.1.2</span>
                                    </summary>
                                    <ul>
                                        <li><input type="checkbox" id="Subelement 1.2.1.2.1"><span>1.2.1.2.1</span></li>
                                        <li><input type="checkbox" id="Subelement 1.2.1.2.2"><span>1.2.1.2.2</span></li>
                                        <li><input type="checkbox" id="Subelement 1.2.1.2.3"><span>1.2.1.2.3</span></li>
                                        <li><input type="checkbox" id="Subelement 1.2.1.2.4"><span>1.2.1.2.4</span></li>
                                    </ul>
                                </details>
                            </li>
                            <li><input type="checkbox" id="Subelement 1.2.1.3"><span>1.2.1.3</span></li>
                            <li><input type="checkbox" id="Subelement 1.2.1.4"><span>1.2.1.4</span></li>
                        </ul>
                    </details>
                </li>
                <li><input type="checkbox" id="Subelement 1.2.2"><span>1.2.2</span></li>
                <li><input type="checkbox" id="Subelement 1.2.3"><span>1.2.3</span></li>
                <li><input type="checkbox" id="Subelement 1.2.4"><span>1.2.4</span></li>
            </ul>
        </details>
    </li>

</ul>



