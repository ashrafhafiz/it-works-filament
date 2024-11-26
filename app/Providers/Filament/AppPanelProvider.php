<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Blade;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Facades\FilamentView;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('/')
            ->login(Login::class)
            // ->registration()
            // ->passwordReset()
            // ->emailVerification()
            // ->profile()
            ->profile(EditProfile::class)
            ->brandName('Filament Demo')
            ->brandLogo(asset('images/gc3-logo2.png'))
            ->brandLogoHeight('4rem')
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            // ->navigationGroups([
            //     NavigationGroup::make()
            //         ->label('External Links')
            //         ->collapsed(),
            // ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Device Management'),
                NavigationGroup::make()
                    ->label('Employee Management'),
                NavigationGroup::make()
                    ->label('Filament Shield'),
                NavigationGroup::make()
                    ->label('System Management'),
                NavigationGroup::make()
                    ->label('External Links')
                    ->collapsed(),
            ])
            ->navigationItems([
                NavigationItem::make('Web Site')
                    ->url('https://gc-3.com', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(1),
                NavigationItem::make('ERP Site')
                    ->url('https://gc3app.com', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(2),
                NavigationItem::make('Helpdesk')
                    ->url('https://helpdesk.gc.local', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(3),
                NavigationItem::make('Endpoint Central')
                    ->url('http://hqvs21opman.gc.local:8020/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(3),
                NavigationItem::make('AD Manager')
                    ->url('http://admanager.gc.local:8080/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(4),
                NavigationItem::make('AD Audit')
                    ->url('http://adaudit.gc.local:8081/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(5),
                NavigationItem::make('Operations manager')
                    ->url('http://hqvs21opman.gc.local:8060/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('External Links')
                    ->sort(6),
            ])
            ->sidebarCollapsibleOnDesktop()
            //
            // ->collapsibleNavigationGroups(true)
            //
            // ->topNavigation()
            //
            // ->userMenuItems([
            //     MenuItem::make()
            //         ->label('Settings')
            //         ->url('/locations')
            //         // ->url(fn(): string => Settings::getUrl())
            //         ->icon('heroicon-o-cog-6-tooth'),
            // ])
            //
            // ->userMenuItems([
            //     MenuItem::make()
            //         ->label('Lock session')
            //         ->postAction(fn(): string => route('lock-session'))
            //         ->icon('heroicon-o-lock-closed'),
            // ])
            //
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 2
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
            ]);
    }

    // for hot reload, but not working !!!
    public function register(): void
    {
        parent::register();
        // FilamentView::registerRenderHook('panels::body.end', fn(): string => Blade::render("@vite('resources/js/app.js')"));
    }
}