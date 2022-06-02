@extends('layouts.app')

@section('content')

<div id="app">
	<div id="MainApp" class="App-root-1">
		<div class="noPrint">
			<div>
				<div>
					<header class="MuiPaper-root MuiAppBar-root MuiAppBar-positionStatic MuiAppBar-colorDefault MuiPaper-elevation4">
						<div class="MuiToolbar-root MuiToolbar-regular MuiToolbar-gutters">
							<p class="MuiTypography-root makeStyles-title-2 MuiTypography-body1 MuiTypography-noWrap">
								<img src="/img/original/logo.png" alt="logo" style="margin: auto; display: block; height: 100%;"></p>
								<div>
									
							</div>
						<div class="makeStyles-sectionDesktop-6"></div>
						<div class="makeStyles-sectionMobile-7">
							<button class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorInherit" tabindex="0" type="button" aria-label="show more" aria-controls="primary-search-account-menu-mobile" aria-haspopup="true"><span class="MuiIconButton-label"><svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg></span><span class="MuiTouchRipple-root"></span></button>
						</div>
					</div>
				</header>

				<div class="MuiGrid-root MuiGrid-container MuiGrid-justify-xs-flex-end">
					<div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-md-8">
						<form class="MuiPaper-root SearchForm-searchForm-234 MuiPaper-elevation1 MuiPaper-rounded">
							<div class="MuiFormControl-root SearchForm-iconButton-236">
								<input type="hidden" name="csrf" value="">
								<div class="MuiInputBase-root MuiInput-root MuiInput-underline MuiInputBase-formControl MuiInput-formControl">
									<div class="MuiSelect-root MuiSelect-select MuiSelect-selectMenu MuiInputBase-input MuiInput-input" tabindex="0" role="button" aria-haspopup="listbox" aria-labelledby="demo-simple-select-label demo-simple-select" id="demo-simple-select">TITLE</div><input type="hidden" value="TITLE"><svg class="MuiSvgIcon-root MuiSelect-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5z"></path></svg></div></div><div class="MuiInputBase-root SearchForm-input-235"><input placeholder="Search by TITLE..." type="text" aria-label="" class="MuiInputBase-input" value=""></div><button class="MuiButtonBase-root MuiIconButton-root SearchForm-iconButton-236" tabindex="0" type="submit" aria-label="search"><span class="MuiIconButton-label"><svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg></span><span class="MuiTouchRipple-root"></span></button></form></div></div></div></div></div><div style="margin: 30px;"><div class="MuiGrid-root MuiGrid-container MuiGrid-justify-xs-center"><div class="MuiGrid-root MuiGrid-item MuiGrid-grid-sm-12 MuiGrid-grid-md-2"><a href="/static/current_catalog" target="_BLANK" rel="noopener noreferrer"><img src="/img/promotions/current_catalog" alt="" style="height: 209px; width: 160px; margin: auto; display: block;"></a>
										
									</div>

									<div class="MuiGrid-root box SearchPage-gridItem-288 MuiGrid-item MuiGrid-grid-sm-12 MuiGrid-grid-md-8">
										<div class="MuiGrid-root search-results MuiGrid-container MuiGrid-spacing-xs-2 MuiGrid-align-items-xs-flex-start MuiGrid-justify-xs-space-between">
										</div>
									</div>
								</div>
								<div class="noPrint"></div>

								<footer class="makeStyles-footer-333 noPrint">
									<div class="MuiContainer-root MuiContainer-maxWidthLg"><h6 class="MuiTypography-root MuiTypography-h6 MuiTypography-gutterBottom MuiTypography-alignCenter"><span id="footerlogo" class="makeStyles-footerImage-334"></span></h6><p class="MuiTypography-root MuiTypography-subtitle1 MuiTypography-colorTextSecondary MuiTypography-alignCenter">The Smart Choice for Large Print! | 1-800-929-9108</p><p class="MuiTypography-root MuiTypography-body2 MuiTypography-colorTextSecondary MuiTypography-alignCenter">© 2020 <a class="MuiTypography-root MuiLink-root MuiLink-underlineHover MuiTypography-colorInherit" href="/">centerpointlargeprint.com</a>.</p></div></footer></div></div>
@endsection
