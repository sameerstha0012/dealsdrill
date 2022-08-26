<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
	<i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" 
		m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
				<a  href="{{ route('admin.dashboard') }}" class="m-menu__link ">
					<i class="m-menu__link-icon flaticon-line-graph"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">
								Dashboard
							</span>
						</span>
					</span>
				</a>
			</li>
			<li class="m-menu__section">
				<h4 class="m-menu__section-text">
					Components
				</h4>
				<i class="m-menu__section-icon flaticon-more-v3"></i>
			</li>
			
			<li class="m-menu__item  m-menu__item" aria-haspopup="true" >
				<a target="_blank" href="{{ route('index') }}" class="m-menu__link ">
					<i class="m-menu__link-icon flaticon-imac"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">
								Visit Site
							</span>
						</span>
					</span>
				</a>
			</li>

			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon flaticon-browser"></i>
					<span class="m-menu__link-text">Manage Website</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>	
				<div class="m-menu__submenu ">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						
						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ url('admin/pages') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-browser"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Menus</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ route('admin.blogList') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-list-3"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Blogs</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ route('admin.advertiseList') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-list-3"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Advertise</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ url('admin/settings') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-list-3"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Settings</span>
									</span>
								</span>
							</a>
						</li>
						
					</ul>
				</div>
			</li>

			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon flaticon-list-3"></i>
					<span class="m-menu__link-text">Categories List</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>	
				<div class="m-menu__submenu ">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						
						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ url('admin/categories') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-list-3"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Categories</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ url('admin/subcategories') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-list-3"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Sub Categories</span>
									</span>
								</span>
							</a>
						</li>

						<li class="m-menu__item m-menu__item" aria-haspopup="true">
							<a href="{{ url('admin/othercategories') }}" class="m-menu__link">
								<i class="m-menu__link-icon flaticon-list-3"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text">Other Categories</span>
									</span>
								</span>
							</a>
						</li>
						
					</ul>
				</div>
			</li>

			<li class="m-menu__item  m-menu__item" aria-haspopup="true" >
				<a  href="{{ url('admin/products') }}" class="m-menu__link ">
					<i class="m-menu__link-icon flaticon-cart"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">
								Products
							</span>
						</span>
					</span>
				</a>
			</li>

			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon flaticon-user"></i>
					<span class="m-menu__link-text">
						User Management
					</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
							<a  href="{{ url('admin/users') }}" class="m-menu__link m-menu__toggle">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Users
								</span>
							</a>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
							<a  href="{{ url('admin/admins') }}" class="m-menu__link m-menu__toggle">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Admins
								</span>
							</a>
						</li>
						
					</ul>
				</div>
			</li>

			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon la la-key"></i>
					<span class="m-menu__link-text">
						Roles & Permissions
					</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
							<a  href="{{ url('admin/roles') }}" class="m-menu__link m-menu__toggle">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Roles
								</span>
							</a>
						</li>	
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
							<a  href="{{ url('admin/permissions') }}" class="m-menu__link m-menu__toggle">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Permisssions
								</span>
							</a>
						</li>									
					</ul>
				</div>
			</li>
		</ul>
	</div>
</div>