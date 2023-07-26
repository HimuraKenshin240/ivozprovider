import DefaultEntityBehavior from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import EntityInterface, {
  OrderDirection,
} from '@irontec/ivoz-ui/entities/EntityInterface';
import _ from '@irontec/ivoz-ui/services/translations/translate';
import ChatBubbleIcon from '@mui/icons-material/ChatBubble';
import { IvozStoreState } from 'store';

import Actions from './Action';
import { BillableCallProperties } from './BillableCallProperties';

const properties: BillableCallProperties = {
  startTime: {
    label: 'Start time',
  },
  callid: {
    label: 'Call ID',
  },
  caller: {
    label: 'Caller',
  },
  callee: {
    label: 'Callee',
  },
  destinationName: {
    label: 'Destination',
  },
  direction: {
    label: 'Direction',
    enum: {
      inbound: _('Inbound'),
      outbound: _('Outbound'),
    },
  },
  invoice: {
    label: 'Invoice',
  },
  price: {
    label: 'Price',
  },
  duration: {
    label: 'Duration',
  },
  cost: {
    label: 'Cost',
  },
  carrierName: {
    label: 'Carrier',
  },
  ratingPlanName: {
    label: 'Rating plan',
  },
  endpointType: {
    label: 'Endpoint type',
  },
  endpointId: {
    label: 'Endpoint id',
  },
  endpointName: {
    label: 'Endpoint name',
  },
  ddiProvider: {
    label: 'DDI Provider',
  },
};

const columns = (store: IvozStoreState) => {
  const billingInfo = store.clientSession.aboutMe.profile?.billingInfo;

  const response = [
    'startTime',
    'direction',
    'caller',
    'callee',
    'duration',
    billingInfo && 'price',
  ];

  return response.filter((column) => column !== false) as Array<string>;
};

const billableCall: EntityInterface = {
  ...DefaultEntityBehavior,
  icon: ChatBubbleIcon,
  link: '/doc/en/administration_portal/client/vpbx/calls/external_calls.html',
  iden: 'BillableCall',
  title: _('External call', { count: 2 }),
  path: '/billable_calls',
  properties,
  columns,
  customActions: Actions,
  acl: {
    ...DefaultEntityBehavior.acl,
    iden: 'BillableCalls',
  },
  Form: async () => {
    const module = await import('./Form');

    return module.default;
  },
  View: async () => {
    const module = await import('./View');

    return module.default;
  },
  defaultOrderBy: 'startTime',
  defaultOrderDirection: OrderDirection.desc,
};

export default billableCall;
