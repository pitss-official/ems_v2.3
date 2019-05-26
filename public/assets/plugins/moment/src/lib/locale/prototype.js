import {Locale} from './constructor';
import {calendar, defaultCalendar} from './calendar';
import {defaultLongDateFormat, longDateFormat} from './formats';
import {defaultInvalidDate, invalidDate} from './invalid';
import {defaultOrdinal, defaultOrdinalParse, ordinal} from './ordinal';
import {preParsePostFormat} from './pre-post-format';
import {defaultRelativeTime, pastFuture, relativeTime} from './relative';
import {set} from './set';
// Month
import {
    defaultLocaleMonths,
    defaultLocaleMonthsShort,
    localeMonths,
    localeMonthsParse,
    localeMonthsShort
} from '../units/month';
// Week
import {defaultLocaleWeek, localeFirstDayOfWeek, localeFirstDayOfYear, localeWeek} from '../units/week';
// Day of Week
import {
    defaultLocaleWeekdays,
    defaultLocaleWeekdaysMin,
    defaultLocaleWeekdaysShort,
    localeWeekdays,
    localeWeekdaysMin,
    localeWeekdaysParse,
    localeWeekdaysShort
} from '../units/day-of-week';
// Hours
import {defaultLocaleMeridiemParse, localeIsPM, localeMeridiem} from '../units/hour';

var proto = Locale.prototype;

proto._calendar       = defaultCalendar;
proto.calendar        = calendar;
proto._longDateFormat = defaultLongDateFormat;
proto.longDateFormat  = longDateFormat;
proto._invalidDate    = defaultInvalidDate;
proto.invalidDate     = invalidDate;
proto._ordinal        = defaultOrdinal;
proto.ordinal         = ordinal;
proto._ordinalParse   = defaultOrdinalParse;
proto.preparse        = preParsePostFormat;
proto.postformat      = preParsePostFormat;
proto._relativeTime   = defaultRelativeTime;
proto.relativeTime    = relativeTime;
proto.pastFuture      = pastFuture;
proto.set             = set;

proto.months       =        localeMonths;
proto._months      = defaultLocaleMonths;
proto.monthsShort  =        localeMonthsShort;
proto._monthsShort = defaultLocaleMonthsShort;
proto.monthsParse  =        localeMonthsParse;

proto.week = localeWeek;
proto._week = defaultLocaleWeek;
proto.firstDayOfYear = localeFirstDayOfYear;
proto.firstDayOfWeek = localeFirstDayOfWeek;

proto.weekdays       =        localeWeekdays;
proto._weekdays      = defaultLocaleWeekdays;
proto.weekdaysMin    =        localeWeekdaysMin;
proto._weekdaysMin   = defaultLocaleWeekdaysMin;
proto.weekdaysShort  =        localeWeekdaysShort;
proto._weekdaysShort = defaultLocaleWeekdaysShort;
proto.weekdaysParse  =        localeWeekdaysParse;

proto.isPM = localeIsPM;
proto._meridiemParse = defaultLocaleMeridiemParse;
proto.meridiem = localeMeridiem;
