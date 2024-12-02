function Navbar({logo, bgcolor, navbgcolor, textColor, svgColor}) {
    return (
        <nav className="navbar bg-body-tertiary fixed-top navbar-expand-lg overflow-hidden" style={{backgroundColor: bgcolor, height: "80px"}}>
            <div className="container-fluid pe-0 ps-0">
                <div className="ps-4">
                    <a className="navbar-brand" href="#">
                        <img src={logo} alt="Bootstrap" width="200px"/>
                    </a>
                </div>
                <div className="w-100 position-absolute" style={{backgroundColor: navbgcolor, height: "80px",borderRadius: "40px 0 0 40px", marginLeft: "280px"}}></div>
                <div id="bigNavbar-l" className="position-absolute" style={{marginLeft: "300px", color: textColor}}>
                    <ul className="navbar-nav me-auto my-lg-0 navbar-nav-scroll ms-4"
                        style={{bsScrollHeight: "80px"}}>
                        <li className="nav-item fs-4 me-3"><a className="dropdown-item" href="#">扭蛋</a></li>
                        <li className="nav-item fs-4 me-3"><a className="dropdown-item" href="#">一番賞</a></li>
                        <li className="nav-item fs-4 me-3"><a className="dropdown-item" href="#">常見問題</a></li>
                        <li className="nav-item fs-4 me-3"><a className="dropdown-item" href="#">聯絡我們</a></li>
                    </ul>
                </div>
                <div id="bigNavbar-r">
                    <ul className="navbar-nav me-auto my-lg-0 pe-4 navbar-nav-scroll"
                        style={{bsScrollHeight: "80px"}}>
                        <li className="nav-item"><a className="dropdown-item" href="#"><img src="./img/member.svg" style={{filter: svgColor}}/></a></li>
                        <li className="nav-item"><a className="dropdown-item" href="#"><img src="./img/notify.svg" style={{filter: svgColor}}/></a></li>
                        <li className="nav-item"><a className="dropdown-item" href="#"><img src="./img/wallet.svg" style={{filter: svgColor}}/></a></li>
                        <li className="nav-item"><a className="dropdown-item" href="#"><img src="./img/cart.svg" style={{filter: svgColor}}/></a></li>
                        <li className="nav-item"><a className="dropdown-item" href="#"><img src="./img/lang.svg" style={{filter: svgColor}}/></a></li>
                    </ul>
                </div>
                <button className="navbar-toggler me-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon" style={{filter: svgColor}}></span>
                </button>
                <div className="offcanvas offcanvas-end" tabIndex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div className="offcanvas-header">
                        <h5 className="offcanvas-title" id="offcanvasNavbarLabel">Gachora</h5>
                        <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div className="offcanvas-body">
                        <ul className="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li className="nav-item">
                                <a className="nav-link" href="#">會員登入</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link active" aria-current="page" href="#">首頁</a>
                            </li>
                            <li className="nav-item dropdown">
                                <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    扭蛋
                                </a>
                                <ul className="dropdown-menu">
                                    <li><a className="dropdown-item" href="#">扭蛋首頁</a></li>
                                    <li><a className="dropdown-item" href="#">扭蛋分類頁</a></li>
                                    <li><a className="dropdown-item" href="#">扭蛋商品頁</a></li>
                                </ul>
                            </li>
                            <li className="nav-item dropdown">
                                <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    一番賞
                                </a>
                                <ul className="dropdown-menu">
                                    <li><a className="dropdown-item" href="#">一番賞首頁</a></li>
                                    <li><a className="dropdown-item" href="#">一番賞分類頁</a></li>
                                    <li><a className="dropdown-item" href="#">一番賞商品頁</a></li>
                                </ul>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#">購物車</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#">我的錢包</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#">常見問題</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#">聯絡我們</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#">English</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    )
}