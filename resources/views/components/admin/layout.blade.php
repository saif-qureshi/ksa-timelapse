<!DOCTYPE html>
<html lang="en" class="">

<head>
    <x-admin.head title="{{ $title }}">
    </x-admin.head>
    <x-admin.styles>
        {{ $style ?? '' }}
    </x-admin.styles>
</head>

<body class="py-5 md:py-0">
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Midone - HTML Admin Template" class="w-6"
                    src="{{ asset('dist/images/logo.jpg') }}">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-white/[0.08] py-5 hidden">
            <li>
                <a href="javascript:;.html" class="menu menu--active">
                    <div class="menu__icon"><i data-lucide="home"></i></div>
                    <div class="menu__title"> Dashboard <i data-lucide="chevron-down"
                            class="menu__sub-icon transform rotate-180"></i></div>
                </a>
                <ul class="menu__sub-open">
                    <li>
                        <a href="side-menu-dark-dashboard-overview-1.html" class="menu menu--active">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 1</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-dashboard-overview-2.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 2</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-dashboard-overview-3.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 3</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-dashboard-overview-4.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 4</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="box"></i></div>
                    <div class="menu__title"> Menu Layout <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-dashboard-overview-1.html" class="menu menu--active">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Side Menu</div>
                        </a>
                    </li>
                    <li>
                        <a href="simple-menu-dark-dashboard-overview-1.html" class="menu menu--active">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Simple Menu</div>
                        </a>
                    </li>
                    <li>
                        <a href="top-menu-dark-dashboard-overview-1.html" class="menu menu--active">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Top Menu</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="side-menu-dark-inbox.html" class="menu">
                    <div class="menu__icon"><i data-lucide="inbox"></i></div>
                    <div class="menu__title"> Inbox</div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-file-manager.html" class="menu">
                    <div class="menu__icon"><i data-lucide="hard-drive"></i></div>
                    <div class="menu__title"> File Manager</div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-point-of-sale.html" class="menu">
                    <div class="menu__icon"><i data-lucide="credit-card"></i></div>
                    <div class="menu__title"> Point of Sale</div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-chat.html" class="menu">
                    <div class="menu__icon"><i data-lucide="message-square"></i></div>
                    <div class="menu__title"> Chat</div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-post.html" class="menu">
                    <div class="menu__icon"><i data-lucide="file-text"></i></div>
                    <div class="menu__title"> Post</div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-calendar.html" class="menu">
                    <div class="menu__icon"><i data-lucide="calendar"></i></div>
                    <div class="menu__title"> Calendar</div>
                </a>
            </li>
            <li class="menu__devider my-6"></li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="edit"></i></div>
                    <div class="menu__title"> Crud <i data-lucide="chevron-down" class="menu__sub-icon "></i></div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-crud-data-list.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Data List</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-crud-form.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Form</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="users"></i></div>
                    <div class="menu__title"> Users <i data-lucide="chevron-down" class="menu__sub-icon "></i></div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-users-layout-1.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Layout 1</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-users-layout-2.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Layout 2</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-users-layout-3.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Layout 3</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="trello"></i></div>
                    <div class="menu__title"> Profile <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-profile-overview-1.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 1</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-profile-overview-2.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 2</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-profile-overview-3.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overview 3</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="layout"></i></div>
                    <div class="menu__title"> Pages <i data-lucide="chevron-down" class="menu__sub-icon "></i></div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Wizards <i data-lucide="chevron-down"
                                    class="menu__sub-icon "></i>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-wizard-layout-1.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wizard-layout-2.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wizard-layout-3.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 3</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Blog <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-blog-layout-1.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-blog-layout-2.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-blog-layout-3.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 3</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Pricing <i data-lucide="chevron-down"
                                    class="menu__sub-icon "></i>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-pricing-layout-1.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-pricing-layout-2.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Invoice <i data-lucide="chevron-down"
                                    class="menu__sub-icon "></i>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-invoice-layout-1.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-invoice-layout-2.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> FAQ <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-faq-layout-1.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-faq-layout-2.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-faq-layout-3.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Layout 3</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="login-dark-login.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Login</div>
                        </a>
                    </li>
                    <li>
                        <a href="login-dark-register.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Register</div>
                        </a>
                    </li>
                    <li>
                        <a href="main-dark-error-page.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Error Page</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-update-profile.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Update profile</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-change-password.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Change Password</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu__devider my-6"></li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="inbox"></i></div>
                    <div class="menu__title"> Components <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Table <i data-lucide="chevron-down"
                                    class="menu__sub-icon "></i></div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-regular-table.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Regular Table</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-tabulator.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Tabulator</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Overlay <i data-lucide="chevron-down"
                                    class="menu__sub-icon "></i>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-modal.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Modal</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-slide-over.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Slide Over</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-notification.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Notification</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="side-menu-dark-Tab.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Tab</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-accordion.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Accordion</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-button.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Button</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-alert.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Alert</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-progress-bar.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Progress Bar</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-tooltip.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Tooltip</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-dropdown.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Dropdown</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-typography.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Typography</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-icon.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Icon</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-loading-icon.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Loading Icon</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="sidebar"></i></div>
                    <div class="menu__title"> Forms <i data-lucide="chevron-down" class="menu__sub-icon "></i></div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-regular-form.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Regular Form</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-datepicker.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Datepicker</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-tom-select.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Tom Select</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-file-upload.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> File Upload</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Wysiwyg Editor <i data-lucide="chevron-down"
                                    class="menu__sub-icon "></i></div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-wysiwyg-editor-classic.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Classic</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wysiwyg-editor-inline.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Inline</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wysiwyg-editor-balloon.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Balloon</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wysiwyg-editor-balloon-block.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Balloon Block</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wysiwyg-editor-document.html" class="menu">
                                    <div class="menu__icon"><i data-lucide="zap"></i></div>
                                    <div class="menu__title">Document</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="side-menu-dark-validation.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Validation</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-lucide="hard-drive"></i></div>
                    <div class="menu__title"> Widgets <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-chart.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Chart</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-slider.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Slider</div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-image-zoom.html" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title"> Image Zoom</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div
        class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] -mt-7 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
        <div class="h-full flex items-center">

            <a href="" class="logo -intro-x hidden md:flex xl:w-[180px]">
                <img alt="{{ config('app.name') }}" class="logo__image w-1/2"
                    src="{{ asset('dist/images/logo.jpg') }}">
            </a>

            <x-admin.breadcrumbs title="{{ $title }}" />

            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
                    role="button" aria-expanded="false" data-tw-toggle="dropdown">
                    <img alt="{{ auth()->user()->name }}" src="https://ui-avatars.com/api/?name=John+Doe">
                </div>
                <div class="dropdown-menu w-56">
                    <ul
                        class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                        <li class="p-2">
                            <div class="font-medium">
                                <a href="">
                                    {{ auth()->user()->name }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-white/[0.08]">
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="dropdown-item hover:bg-white/5">
                                <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
    <div class="flex overflow-hidden">
        <x-admin.sidebar></x-admin.sidebar>
        <div class="content" id="app">
            {{ $slot }}
        </div>
    </div>

    <x-admin.toaster />

    <x-admin.scripts>
        {{ $script ?? '' }}
    </x-admin.scripts>
</body>

</html>
