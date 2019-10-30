<?php
/**
 * Модуль авторизации
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-10-15
 */
class auth
{
	public static function is_login()
	{
		return session::get('auth', false);
	}
	public static function login($user = true)
	{
		session::set('auth', $user);
	}
	public static function logout()
	{
		session::set('auth', NULL);
	}
	public static function register()
	{
	}
	public static function form_login()
	{
		template::load('auth/login');
	}
	public static function form_logout()
	{
		template::load('auth/logout');
	}
	public static function form_register()
	{
		template::load('auth/register');
	}
}
