import { useCallback, useEffect, useRef, useState } from 'react';

import {
  Calls,
  InputStruct,
  isTryingStruct,
  isUpdateStruct,
  OutputStuct,
  TryingStuct,
  UpdateStuct,
  WsFilters,
} from '../types';
import useWsClient from './useWsClient';

interface UseRealtimeCallsProps {
  filters?: WsFilters;
}

const useRealtimeCalls = (props: UseRealtimeCallsProps): [boolean, Calls] => {
  const { filters } = props;
  const [calls, setCalls] = useState<Calls>({});
  const syncCallsRef = useRef<Calls>({});
  syncCallsRef.current = { ...calls };

  const updateCall = (data: UpdateStuct) => {
    const callId = data['Call-ID'];
    const event = data.Event;

    const newValue = {
      ...syncCallsRef.current,
    };

    newValue[callId] = {
      ...newValue[callId],
      event,
    };

    if (event === 'Confirmed') {
      setCalls(() => {
        newValue[callId] = {
          ...newValue[callId],
          time: data.Time,
        };

        syncCallsRef.current = newValue;

        return newValue;
      });
    } else if (event === 'Terminated') {
      // _hideRow
      setCalls(() => {
        delete newValue[callId];

        syncCallsRef.current = newValue;

        return newValue;
      });
    }
  };

  const createCall = (data: TryingStuct) => {
    const callId = data['Call-ID'];

    const newRow: OutputStuct = {
      id: data.ID,
      callId: callId,
      brand: data.Brand,
      direction: data.Direction,
      event: data.Event,
      time: data.Time,
      duration: '',
      company: data.Company,
      caller: data.Caller,
      callee: data.Callee,
      operator: data.Carrier ?? data.DdiProvider ?? '',
    };

    setCalls(() => {
      const newValue = {
        ...syncCallsRef.current,
        [callId]: newRow,
      };

      syncCallsRef.current = newValue;

      return newValue;
    });
  };

  const onMessage = useCallback((data: InputStruct) => {
    const callId = data['Call-ID'];

    if (isUpdateStruct(data) && syncCallsRef.current[callId]) {
      return updateCall(data);
    }

    if (isTryingStruct(data) && data.Event !== 'Terminated') {
      return createCall(data);
    }

    // eslint-disable-next-line no-console
    console.log('Ignore update for unknown call', data);
  }, []);

  const wsServerUrl = `wss://${document.location.hostname}/wss`;
  const ready = useWsClient<TryingStuct>({
    wsServerUrl,
    onMessage,
    filters,
  });

  useEffect(() => {
    const interval = setInterval(() => {
      if (Object.keys(syncCallsRef.current).length === 0) {
        return;
      }

      const newValue = {
        ...syncCallsRef.current,
      };

      const now = Math.round(new Date().getTime() / 1000);

      for (const idx in newValue) {
        let seconds = Math.max(now - newValue[idx].time, 0);

        let minutes = Math.floor(seconds / 60);

        const hours = Math.floor(seconds / 60 / 60);
        if (hours >= 3) {
          delete newValue[idx];
          continue;
        }

        minutes -= hours * 60;
        seconds -= hours * 60 * 60 + minutes * 60;

        const hoursStr = hours > 0 ? `${hours}h ` : '';
        const minutesStr = minutes > 0 ? `${minutes}m ` : '';

        newValue[idx].duration = `${hoursStr + minutesStr + seconds}s`;
      }

      setCalls(newValue);
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  useEffect(() => {
    if (!ready) {
      setCalls({});
    }
  }, [ready]);

  return [ready, calls];
};

export default useRealtimeCalls;
