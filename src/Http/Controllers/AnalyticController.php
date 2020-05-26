<?php

namespace Sudo\Analytic\Http\Controllers;

use Illuminate\Http\Request;

use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class AnalyticController
{


	/**
	 * Lấy số lượng người đang online hiện tại
	 */
	public function getActiveVisitor()
	{
		try {
			$data = Analytics::getAnalyticsService()
							->data_realtime
							->get('ga:'.config('analytics.view_id'), 'rt:activeVisitors')
							->totalsForAllResults['rt:activeVisitors'];
			return $data;
		} catch (\Exception $e) {
			Log::error($e);
			return __('Analytic::general.error');
		}
	}

	/**
	 * Lấy số lượng trình duyệt truy cập nhiều nhất
	 */
	public function getTopBrowsers(Request $request)
	{
		try {
			$other = [
				'dimensions' => 'ga:browser',
                'sort' => '-ga:sessions',
                'max-results' => $request->max_result ?? 10,
			];
			if (isset($request->date_start)) {
				$other['start-date'] = $request->date_start;
			}
			if (isset($request->date_end)) {
				$other['end-date'] = $request->date_end;
			}

			$data = Analytics::performQuery(Period::days(0), 'ga:sessions', $other);

	        $topBrowsers = collect($data['rows'] ?? [])->map(function (array $browserRow) {
	            return [
	                'browser' => $browserRow[0],
	                'sessions' => (int) $browserRow[1],
	            ];
	        });

			return [
				'status' => 1,
				'data' => $topBrowsers,
			];
		} catch (\Exception $e) {
			\Log::error($e);
			return [
				'status' => 2,
				'message' => __('Analytic::general.error'),
			];
		}
	}

	/**
	 * Lấy số lượng nguồn vào từ đâu
	 */
	public function getTopReferrers(Request $request)
	{
		try {
			$other = [
				'dimensions' => 'ga:fullReferrer',
                'sort' => '-ga:pageviews',
                'max-results' => $request->max_result ?? 10,
			];
			if (isset($request->date_start)) {
				$other['start-date'] = $request->date_start;
			}
			if (isset($request->date_end)) {
				$other['end-date'] = $request->date_end;
			}

			$data = Analytics::performQuery(Period::days(0), 'ga:pageviews', $other );

			$topReferrers = collect($data['rows'] ?? [])->map(function (array $pageRow) {
	            return [
	                'url' => $pageRow[0],
	                'pageViews' => (int) $pageRow[1],
	            ];
	        });

			return [
				'status' => 1,
				'data' => $topReferrers,
			];
		} catch (\Exception $e) {
			\Log::error($e);
			return [
				'status' => 2,
				'message' => __('Analytic::general.error'),
			];
		}
	}

}